<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\LabOrderModel;
use App\Models\PatientModel;
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
        $formData   = $this->requestFormData();
        $catalogs   = $this->loadCatalogs();

        if (! $validation->setRules($this->fieldRules())->run($formData)) {
            return $this->renderForm(array_merge($order, $formData), $validation);
        }

        $customErrors = $this->customValidationErrors($formData, $order, $catalogs);

        if ($customErrors !== []) {
            foreach ($customErrors as $field => $message) {
                $validation->setError($field, $message);
            }

            return $this->renderForm(array_merge($order, $formData), $validation);
        }

        $existingAttachments = is_array($order['attachments'] ?? null) ? $order['attachments'] : [];
        $attachments = $existingAttachments;
        $attachmentError = $this->handleAttachmentsUpload($attachments, count($existingAttachments));

        if ($attachmentError !== null) {
            $validation->setError('attachments', $attachmentError);

            return $this->renderForm(array_merge($order, $formData, ['attachments' => $attachments]), $validation);
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

        return redirect()->to('/admin/ordenes')->with('success', 'Orden actualizada correctamente.');
    }

    private function renderForm(array $order, $validation): string
    {
        $catalogs = $this->loadCatalogs();
        $mappedOrder = $this->mapOrderToFormData($order);

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
}
