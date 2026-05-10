<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;
use App\Models\ClientModel;
use App\Models\LabOrderModel;
use App\Models\OrderEditLogModel;
use App\Models\PatientModel;
use CodeIgniter\Email\Email;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class Orders extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $labOrderModel = new LabOrderModel();

        if ($query !== '') {
            $labOrderModel
                ->groupStart()
                ->like('order_number', $query)
                ->orLike('dentist_name', $query)
                ->orLike('patient_name', $query)
                ->orLike('contact_phone', $query)
                ->groupEnd();
        }

        $orders = $labOrderModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/orders/index', [
            'pageTitle'       => 'Admin de Órdenes - POT Prótesis Dental',
            'metaDescription' => 'Panel administrativo para consultar y editar órdenes.',
            'orders'          => $orders,
            'searchQuery'     => $query,
        ]);
    }

    public function edit(int $id): string
    {
        $order = $this->findOrderOrFail($id);

        return $this->renderForm($order, service('validation'));
    }

    public function unlock(int $id)
    {
        $order = $this->findOrderOrFail($id);

        if (! admin_can_unlock_order_edits()) {
            return redirect()->to('/admin/ordenes')
                ->with('error', 'No tiene permisos para desbloquear la edición completa de órdenes.');
        }

        $password = (string) $this->request->getPost('unlock_password');
        $observations = trim((string) $this->request->getPost('unlock_observations'));
        $errors = [];

        if ($password === '') {
            $errors['unlock_password'] = 'Capture su contraseña para autorizar la edición.';
        }

        if ($observations === '') {
            $errors['unlock_observations'] = 'Indique el motivo de la edición.';
        } elseif ((function_exists('mb_strlen') ? mb_strlen($observations, 'UTF-8') : strlen($observations)) > 2000) {
            $errors['unlock_observations'] = 'Las observaciones no deben exceder 2000 caracteres.';
        }

        $sessionUser = admin_auth_user();
        $adminUser = is_array($sessionUser)
            ? (new AdminUserModel())->find((int) ($sessionUser['id'] ?? 0))
            : null;

        if (! is_array($adminUser) || ! (bool) ($adminUser['is_active'] ?? false) || ! password_verify($password, (string) ($adminUser['password_hash'] ?? ''))) {
            $errors['unlock_password'] = 'La contraseña no coincide con su usuario actual.';
        }

        if ($errors !== []) {
            return redirect()->to('/admin/ordenes/editar/' . $order['id'])
                ->with('unlock_errors', $errors)
                ->with('unlock_old', ['unlock_observations' => $observations])
                ->with('show_unlock_modal', true);
        }

        $logId = (int) (new OrderEditLogModel())->insert([
            'order_id'         => $order['id'],
            'admin_user_id'    => $adminUser['id'],
            'admin_username'   => (string) ($adminUser['username'] ?? ''),
            'admin_full_name'  => (string) ($adminUser['full_name'] ?? ''),
            'observations'     => $observations,
        ], true);

        $this->grantOrderFullEditAccess($order['id'], $logId);

        return redirect()->to('/admin/ordenes/editar/' . $order['id'])
            ->with('success', 'Edición completa autorizada. Ya puede modificar la orden.');
    }

    public function downloadAttachment(int $id, int $index)
    {
        $order = $this->findOrderOrFail($id);
        $attachments = is_array($order['attachments'] ?? null) ? $order['attachments'] : [];
        $attachment = $attachments[$index] ?? null;

        if (! is_array($attachment)) {
            throw PageNotFoundException::forPageNotFound('Archivo no encontrado.');
        }

        $relativePath = trim((string) ($attachment['path'] ?? ''));

        if ($relativePath === '') {
            throw PageNotFoundException::forPageNotFound('Archivo no encontrado.');
        }

        $filePath = WRITEPATH . ltrim($relativePath, '/\\');

        if (! is_file($filePath)) {
            throw PageNotFoundException::forPageNotFound('El archivo ya no existe en el servidor.');
        }

        $downloadName = (string) ($attachment['original_name'] ?? basename($filePath));

        return $this->response
            ->download($filePath, null)
            ->setFileName($downloadName);
    }

    public function update(int $id)
    {
        $order      = $this->findOrderOrFail($id);
        $validation = service('validation');
        $statusData  = $this->requestStatusFormData();
        $previousStatus = (string) ($order['status'] ?? 'recibida');
        $isFullEditUnlocked = $this->isOrderFullyUnlocked($id);

        if (! $isFullEditUnlocked) {
            if (! $validation->setRules($this->statusRules())->run($statusData)) {
                return $this->renderForm(array_merge($order, $statusData), $validation, [
                    'isFullEditUnlocked' => false,
                ]);
            }

            (new LabOrderModel())->update($id, [
                'status' => $statusData['status'],
            ]);

            $updatedOrder = $this->findOrderOrFail($id);
            $this->sendStatusChangeEmail(
                $updatedOrder,
                $this->findClientRecord((int) ($updatedOrder['client_id'] ?? 0)),
                $previousStatus,
                $statusData['status']
            );

            return redirect()->to('/admin/ordenes')->with('success', 'Estatus de la orden actualizado correctamente.');
        }

        $formData = $this->requestFormData();
        $catalogs = $this->loadCatalogs();

        if (! $validation->setRules($this->fieldRules())->run($formData)) {
            return $this->renderForm(array_merge($order, $formData), $validation, [
                'isFullEditUnlocked' => true,
            ]);
        }

        $customErrors = $this->customValidationErrors($formData, $order, $catalogs);

        if ($customErrors !== []) {
            foreach ($customErrors as $field => $message) {
                $validation->setError($field, $message);
            }

            return $this->renderForm(array_merge($order, $formData), $validation, [
                'isFullEditUnlocked' => true,
            ]);
        }

        $existingAttachments = is_array($order['attachments'] ?? null) ? $order['attachments'] : [];
        $attachments = $existingAttachments;
        $attachmentError = $this->handleAttachmentsUpload($attachments, count($existingAttachments));

        if ($attachmentError !== null) {
            $validation->setError('attachments', $attachmentError);

            return $this->renderForm(array_merge($order, $formData, ['attachments' => $attachments]), $validation, [
                'isFullEditUnlocked' => true,
            ]);
        }

        $client = $this->findClientById($formData['client_id'], $catalogs['clients']);
        $patient = $this->findPatientById($formData['patient_id'], $catalogs['patients']);

        (new LabOrderModel())->update($id, [
            'required_date'     => $formData['required_date'],
            'client_id'         => $formData['client_id'],
            'patient_id'        => $formData['patient_id'],
            'dentist_name'      => (string) ($client['name'] ?? ''),
            'patient_name'      => (string) ($patient['name'] ?? ''),
            'contact_phone'     => (string) ($client['contact_phone'] ?? ''),
            'status'            => $formData['status'],
            'shade'             => $formData['shade'] !== '' ? $formData['shade'] : null,
            'work_types'        => $formData['work_types'],
            'selected_teeth'    => $formData['selected_teeth'],
            'restoration_types' => $formData['restoration_types'],
            'implant_case'      => $formData['implant_case'] ? 1 : 0,
            'implant_chimney'   => $formData['implant_chimney'],
            'attachments'       => $attachments,
            'observations'      => $formData['observations'] !== '' ? $formData['observations'] : null,
            'signature_name'    => null,
        ]);

        $this->clearOrderFullEditAccess($id);

        $updatedOrder = $this->findOrderOrFail($id);
        $this->sendStatusChangeEmail(
            $updatedOrder,
            $this->findClientRecord((int) ($updatedOrder['client_id'] ?? 0)),
            $previousStatus,
            $formData['status']
        );

        return redirect()->to('/admin/ordenes')->with('success', 'Orden actualizada correctamente.');
    }

    private function renderForm(array $order, $validation, array $context = []): string
    {
        $catalogs = $this->loadCatalogs();
        $mappedOrder = $this->mapOrderToFormData($order);
        $isFullEditUnlocked = (bool) ($context['isFullEditUnlocked'] ?? $this->isOrderFullyUnlocked((int) ($mappedOrder['id'] ?? 0)));

        return view('admin/orders/form', [
            'pageTitle'        => 'Editar Orden - POT Prótesis Dental',
            'metaDescription'  => 'Edición administrativa de órdenes.',
            'order'            => $mappedOrder,
            'validation'       => $validation,
            'clients'          => $catalogs['clients'],
            'patients'         => $catalogs['patients'],
            'workTypes'        => pot_work_types(),
            'restorationTypes' => pot_restoration_types(),
            'upperTeeth'       => pot_upper_teeth(),
            'lowerTeeth'       => pot_lower_teeth(),
            'implantOptions'   => pot_implant_chimney_options(),
            'minRequiredDate'  => pot_min_required_date($mappedOrder['created_at'] ?? ''),
            'isFullEditUnlocked' => $isFullEditUnlocked,
            'canUnlockFullEdit'  => admin_can_unlock_order_edits(),
            'unlockErrors'       => session()->getFlashdata('unlock_errors') ?? [],
            'unlockOld'          => session()->getFlashdata('unlock_old') ?? [],
            'showUnlockModal'    => (bool) (session()->getFlashdata('show_unlock_modal') ?? false),
        ]);
    }

    private function findOrderOrFail(int $id): array
    {
        $order = (new LabOrderModel())->find($id);

        if (! is_array($order)) {
            throw PageNotFoundException::forPageNotFound('Orden no encontrada.');
        }

        return $order;
    }

    private function mapOrderToFormData(array $order): array
    {
        return [
            'id'                => $order['id'] ?? null,
            'order_number'      => (string) ($order['order_number'] ?? ''),
            'sent_date'         => (string) ($order['sent_date'] ?? ''),
            'required_date'     => (string) ($order['required_date'] ?? ''),
            'client_id'         => (int) ($order['client_id'] ?? 0),
            'patient_id'        => (int) ($order['patient_id'] ?? 0),
            'status'            => (string) ($order['status'] ?? 'recibida'),
            'dentist_name'      => (string) ($order['dentist_name'] ?? ''),
            'patient_name'      => (string) ($order['patient_name'] ?? ''),
            'contact_phone'     => (string) ($order['contact_phone'] ?? ''),
            'shade'             => (string) ($order['shade'] ?? ''),
            'work_types'        => is_array($order['work_types'] ?? null) ? $order['work_types'] : [],
            'selected_teeth'    => is_array($order['selected_teeth'] ?? null) ? $order['selected_teeth'] : [],
            'restoration_types' => is_array($order['restoration_types'] ?? null) ? $order['restoration_types'] : [],
            'implant_case'      => (bool) ($order['implant_case'] ?? false),
            'implant_chimney'   => (string) ($order['implant_chimney'] ?? 'none'),
            'attachments'       => is_array($order['attachments'] ?? null) ? $order['attachments'] : [],
            'observations'      => (string) ($order['observations'] ?? ''),
            'created_at'        => (string) ($order['created_at'] ?? ''),
        ];
    }

    private function requestFormData(): array
    {
        $implantCase = $this->request->getPost('implant_case') === '1';

        return [
            'required_date'     => trim((string) $this->request->getPost('required_date')),
            'client_id'         => (int) $this->request->getPost('client_id'),
            'patient_id'        => (int) $this->request->getPost('patient_id'),
            'status'            => trim((string) $this->request->getPost('status')) ?: 'recibida',
            'shade'             => trim((string) $this->request->getPost('shade')),
            'work_types'        => $this->filterAllowedArray((array) $this->request->getPost('work_types'), pot_work_types()),
            'selected_teeth'    => $this->filterAllowedArray((array) $this->request->getPost('selected_teeth'), pot_all_teeth()),
            'restoration_types' => $this->filterAllowedArray((array) $this->request->getPost('restoration_types'), pot_restoration_types()),
            'implant_case'      => $implantCase,
            'implant_chimney'   => trim((string) $this->request->getPost('implant_chimney')) ?: 'none',
            'observations'      => trim((string) $this->request->getPost('observations')),
        ];
    }

    private function requestStatusFormData(): array
    {
        return [
            'status' => trim((string) $this->request->getPost('status')) ?: 'recibida',
        ];
    }

    private function fieldRules(): array
    {
        return [
            'required_date'  => 'required|valid_date[Y-m-d]',
            'client_id'      => 'required|integer|greater_than[0]',
            'patient_id'     => 'required|integer|greater_than[0]',
            'status'         => 'required|in_list[recibida,en_proceso,lista,entregada,cancelada]',
            'shade'          => 'permit_empty|max_length[50]',
            'observations'   => 'permit_empty|max_length[2000]',
        ];
    }

    private function statusRules(): array
    {
        return [
            'status' => 'required|in_list[recibida,en_proceso,lista,entregada,cancelada]',
        ];
    }

    private function customValidationErrors(array $formData, ?array $order = null, ?array $catalogs = null): array
    {
        $errors = [];
        $catalogs ??= $this->loadCatalogs();

        if ($formData['work_types'] === []) {
            $errors['work_types'] = 'Seleccione al menos un trabajo.';
        }

        if ($formData['selected_teeth'] === []) {
            $errors['selected_teeth'] = 'Seleccione al menos un diente.';
        }

        $client = $this->findClientById($formData['client_id'], $catalogs['clients']);
        $patient = $this->findPatientById($formData['patient_id'], $catalogs['patients']);

        if ($client === null) {
            $errors['client_id'] = 'Seleccione un cliente válido.';
        }

        if ($patient === null) {
            $errors['patient_id'] = 'Seleccione un paciente válido.';
        } elseif ((int) ($patient['client_id'] ?? 0) !== (int) $formData['client_id']) {
            $errors['patient_id'] = 'El paciente no pertenece al cliente seleccionado.';
        }

        $minRequiredDate = pot_min_required_date($order['created_at'] ?? null);

        if ($formData['required_date'] !== '' && $formData['required_date'] < $minRequiredDate) {
            $errors['required_date'] = 'La fecha requerida debe ser al menos 7 días después de la fecha de creación.';
        }

        if (! array_key_exists($formData['implant_chimney'], pot_implant_chimney_options())) {
            $errors['implant_chimney'] = 'Seleccione una opción de implante válida.';
        }

        if (! $formData['implant_case'] && $formData['implant_chimney'] !== 'none') {
            $errors['implant_chimney'] = 'La chimenea solo aplica en prótesis sobre implante.';
        }

        if ($formData['implant_case'] && $formData['implant_chimney'] === 'none') {
            $errors['implant_chimney'] = 'Seleccione si el caso sobre implante es con o sin chimenea.';
        }

        return $errors;
    }

    private function filterAllowedArray(array $values, array $allowed): array
    {
        $filtered = array_values(array_intersect($values, $allowed));

        return array_values(array_unique(array_map('strval', $filtered)));
    }

    private function handleAttachmentsUpload(array &$attachments, int $existingCount = 0): ?string
    {
        $files = $this->request->getFileMultiple('attachments');

        if (! is_array($files) || $files === []) {
            return null;
        }

        $validFiles = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $validFiles[] = $file;
        }

        if ($validFiles === []) {
            return null;
        }

        if ($existingCount + count($validFiles) > 5) {
            return 'Solo se pueden adjuntar hasta 5 archivos por orden.';
        }

        $targetPath = WRITEPATH . 'uploads/orders';

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        foreach ($validFiles as $file) {
            if (! $file->isValid()) {
                return 'No fue posible cargar uno de los archivos seleccionados.';
            }

            $extension = strtolower($file->getExtension());

            if (! in_array($extension, ['stl', 'otl', 'pdf'], true)) {
                return 'Los archivos permitidos son STL, OTL y PDF.';
            }

            $newName = $file->getRandomName();
            $file->move($targetPath, $newName, true);

            $attachments[] = [
                'original_name' => $file->getClientName(),
                'stored_name' => $newName,
                'path' => 'uploads/orders/' . $newName,
                'extension' => $extension,
                'size' => $file->getSize(),
            ];
        }

        return null;
    }

    private function loadCatalogs(): array
    {
        $clients = (new ClientModel())
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $patients = (new PatientModel())
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        return [
            'clients' => $clients,
            'patients' => $patients,
        ];
    }

    private function findClientById(int $id, array $clients): ?array
    {
        foreach ($clients as $client) {
            if ((int) ($client['id'] ?? 0) === $id) {
                return $client;
            }
        }

        return null;
    }

    private function findPatientById(int $id, array $patients): ?array
    {
        foreach ($patients as $patient) {
            if ((int) ($patient['id'] ?? 0) === $id) {
                return $patient;
            }
        }

        return null;
    }

    private function findClientRecord(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $client = (new ClientModel())->find($id);

        return is_array($client) ? $client : null;
    }

    private function isOrderFullyUnlocked(int $orderId): bool
    {
        if (! admin_can_unlock_order_edits()) {
            return false;
        }

        $unlockMap = $this->session->get('admin_order_edit_unlocks');

        return is_array($unlockMap) && isset($unlockMap[$orderId]);
    }

    private function grantOrderFullEditAccess(int $orderId, int $logId): void
    {
        $unlockMap = $this->session->get('admin_order_edit_unlocks');

        if (! is_array($unlockMap)) {
            $unlockMap = [];
        }

        $unlockMap[$orderId] = [
            'log_id'     => $logId,
            'granted_at' => date('Y-m-d H:i:s'),
        ];

        $this->session->set('admin_order_edit_unlocks', $unlockMap);
    }

    private function clearOrderFullEditAccess(int $orderId): void
    {
        $unlockMap = $this->session->get('admin_order_edit_unlocks');

        if (! is_array($unlockMap) || ! isset($unlockMap[$orderId])) {
            return;
        }

        unset($unlockMap[$orderId]);

        if ($unlockMap === []) {
            $this->session->remove('admin_order_edit_unlocks');

            return;
        }

        $this->session->set('admin_order_edit_unlocks', $unlockMap);
    }

    private function sendStatusChangeEmail(array $order, ?array $client, string $previousStatus, string $newStatus): void
    {
        if ($previousStatus === $newStatus || ! is_array($client)) {
            return;
        }

        $emailAddress = trim((string) ($client['email'] ?? ''));

        if ($emailAddress === '') {
            return;
        }

        try {
            /** @var Email $email */
            $email = service('email');
            $config = config('Email');
            $fromEmail = $config->fromEmail !== '' ? $config->fromEmail : 'no-reply@localhost';
            $fromName = $config->fromName !== '' ? $config->fromName : 'POT Prótesis Dental';
            $orderNumber = (string) ($order['order_number'] ?: '#' . $order['id']);
            $clientName = (string) ($client['name'] ?? $order['dentist_name'] ?? 'Cliente');

            $htmlMessage = view('emails/order_status_update', [
                'clientName'         => $clientName,
                'orderNumber'        => $orderNumber,
                'patientName'        => (string) ($order['patient_name'] ?? ''),
                'previousStatus'     => pot_order_status_label($previousStatus),
                'newStatus'          => pot_order_status_label($newStatus),
                'contactPhone'       => site_setting('contact_phone', ''),
                'contactEmail'       => site_setting('contact_email', $fromEmail),
            ]);

            $textMessage = "Hola {$clientName},\n\n"
                . "La orden {$orderNumber} cambió de estatus.\n"
                . 'Estatus anterior: ' . pot_order_status_label($previousStatus) . "\n"
                . 'Nuevo estatus: ' . pot_order_status_label($newStatus) . "\n"
                . 'Paciente: ' . ((string) ($order['patient_name'] ?? 'No especificado')) . "\n\n"
                . "POT Prótesis Dental";

            $email->setFrom($fromEmail, $fromName);
            $email->setTo($emailAddress);
            $email->setSubject('Actualización de estatus de tu orden ' . $orderNumber);
            $email->setMessage($htmlMessage);
            $email->setAltMessage($textMessage);
            $email->send(false);
        } catch (\Throwable $exception) {
            log_message('error', 'No fue posible enviar el correo de actualización de estatus para la orden {orderId}: {message}', [
                'orderId' => $order['id'] ?? 0,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
