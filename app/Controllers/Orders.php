<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\LabOrderModel;
use App\Models\PatientModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Orders extends BaseController
{
    public function create()
    {
        $validation = service('validation');
        $clientUser = client_auth_user();
        $formData   = $this->defaultFormData($clientUser);
        $catalogs   = $this->loadCatalogs($clientUser);

        if ($this->request->getMethod() === 'post') {
            $formData = $this->requestFormData($clientUser);
            $minRequiredDate = pot_min_required_date();

            if (! $validation->setRules($this->fieldRules())->run($formData)) {
                return view('orders/create', [
                    'pageTitle'       => 'Orden de Laboratorio - POT Prótesis Dental',
                    'metaDescription' => 'Formulario digital para registrar órdenes de trabajo de prótesis dental.',
                    'validation'      => $validation,
                    'formData'        => $formData,
                    'clients'         => $catalogs['clients'],
                    'patients'        => $catalogs['patients'],
                    'clientUser'      => $clientUser,
                    'workTypes'       => pot_work_types(),
                    'restorationTypes'=> pot_restoration_types(),
                    'upperTeeth'      => pot_upper_teeth(),
                    'lowerTeeth'      => pot_lower_teeth(),
                    'implantOptions'  => pot_implant_chimney_options(),
                    'minRequiredDate' => $minRequiredDate,
                ]);
            }

            $customErrors = $this->customValidationErrors($formData, $catalogs, $minRequiredDate);

            if ($customErrors !== []) {
                foreach ($customErrors as $field => $message) {
                    $validation->setError($field, $message);
                }

                return view('orders/create', [
                    'pageTitle'       => 'Orden de Laboratorio - POT Prótesis Dental',
                    'metaDescription' => 'Formulario digital para registrar órdenes de trabajo de prótesis dental.',
                    'validation'      => $validation,
                    'formData'        => $formData,
                    'clients'         => $catalogs['clients'],
                    'patients'        => $catalogs['patients'],
                    'clientUser'      => $clientUser,
                    'workTypes'       => pot_work_types(),
                    'restorationTypes'=> pot_restoration_types(),
                    'upperTeeth'      => pot_upper_teeth(),
                    'lowerTeeth'      => pot_lower_teeth(),
                    'implantOptions'  => pot_implant_chimney_options(),
                    'minRequiredDate' => $minRequiredDate,
                ]);
            }

            $attachments = [];
            $attachmentError = $this->handleAttachmentsUpload($attachments);

            if ($attachmentError !== null) {
                $validation->setError('attachments', $attachmentError);

                return view('orders/create', [
                    'pageTitle'       => 'Orden de Laboratorio - POT Prótesis Dental',
                    'metaDescription' => 'Formulario digital para registrar órdenes de trabajo de prótesis dental.',
                    'validation'      => $validation,
                    'formData'        => $formData,
                    'clients'         => $catalogs['clients'],
                    'patients'        => $catalogs['patients'],
                    'clientUser'      => $clientUser,
                    'workTypes'       => pot_work_types(),
                    'restorationTypes'=> pot_restoration_types(),
                    'upperTeeth'      => pot_upper_teeth(),
                    'lowerTeeth'      => pot_lower_teeth(),
                    'implantOptions'  => pot_implant_chimney_options(),
                    'minRequiredDate' => $minRequiredDate,
                ]);
            }

            $client = $this->findClientById($formData['client_id'], $catalogs['clients']);
            $patient = $this->findPatientById($formData['patient_id'], $catalogs['patients']);
            $model = new LabOrderModel();
            $insertData = [
                'order_number'      => null,
                'sent_date'         => date('Y-m-d'),
                'required_date'     => $formData['required_date'],
                'client_id'         => $formData['client_id'] > 0 ? $formData['client_id'] : null,
                'patient_id'        => $formData['patient_id'] > 0 ? $formData['patient_id'] : null,
                'dentist_name'      => (string) ($client['name'] ?? ''),
                'patient_name'      => (string) ($patient['name'] ?? ''),
                'contact_phone'     => (string) ($client['contact_phone'] ?? ''),
                'status'            => 'recibida',
                'shade'             => $formData['shade'] !== '' ? $formData['shade'] : null,
                'work_types'        => json_encode($formData['work_types'], JSON_UNESCAPED_UNICODE),
                'selected_teeth'    => json_encode($formData['selected_teeth'], JSON_UNESCAPED_UNICODE),
                'restoration_types' => json_encode($formData['restoration_types'], JSON_UNESCAPED_UNICODE),
                'implant_case'      => $formData['implant_case'] ? 1 : 0,
                'implant_chimney'   => $formData['implant_chimney'],
                'attachments'       => $attachments === [] ? null : json_encode($attachments, JSON_UNESCAPED_UNICODE),
                'observations'      => $formData['observations'] !== '' ? $formData['observations'] : null,
                'signature_name'    => null,
            ];

            if (! $model->insert($insertData)) {
                $errors = $model->errors();
                $this->logModelFailure('lab order insert', $errors);
                $validation->setError('form', 'No fue posible guardar la orden en la base de datos.');

                foreach ($errors as $field => $message) {
                    $validation->setError((string) $field, (string) $message);
                }
            } else {
                return redirect()->to('/orden-laboratorio')
                    ->with('success', 'La orden quedó registrada correctamente.');
            }
        }

        return view('orders/create', [
            'pageTitle'       => 'Orden de Laboratorio - POT Prótesis Dental',
            'metaDescription' => 'Formulario digital para registrar órdenes de trabajo de prótesis dental.',
            'validation'      => $validation,
            'formData'        => $formData,
            'clients'         => $catalogs['clients'],
            'patients'        => $catalogs['patients'],
            'clientUser'      => $clientUser,
            'workTypes'       => pot_work_types(),
            'restorationTypes'=> pot_restoration_types(),
            'upperTeeth'      => pot_upper_teeth(),
            'lowerTeeth'      => pot_lower_teeth(),
            'implantOptions'  => pot_implant_chimney_options(),
            'minRequiredDate' => pot_min_required_date(),
        ]);
    }

    public function storePatient()
    {
        $clientUser = client_auth_user();

        if (! is_array($clientUser) || ! isset($clientUser['id'])) {
            return $this->response->setStatusCode(403)->setJSON([
                'message' => 'Debes iniciar sesión como cliente para agregar pacientes.',
                'csrf' => csrf_hash(),
            ]);
        }

        $data = [
            'client_id' => (int) $clientUser['id'],
            'name' => trim((string) $this->request->getPost('name')),
            'notes' => trim((string) $this->request->getPost('notes')) ?: null,
            'is_active' => 1,
        ];

        $rules = [
            'name' => 'required|min_length[3]|max_length[160]',
            'notes' => 'permit_empty|max_length[2000]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Revise los datos capturados.',
                'errors' => $this->validator?->getErrors() ?? [],
                'csrf' => csrf_hash(),
            ]);
        }

        $model = new PatientModel();
        if (! $model->insert($data)) {
            $this->logModelFailure('quick patient insert', $model->errors());

            return $this->response->setStatusCode(500)->setJSON([
                'message' => 'No fue posible crear el paciente en la base de datos.',
                'errors' => $model->errors(),
                'csrf' => csrf_hash(),
            ]);
        }

        $patientId = (int) $model->getInsertID();
        $patient = $model->find($patientId);

        if (! is_array($patient)) {
            return $this->response->setStatusCode(500)->setJSON([
                'message' => 'No fue posible crear el paciente.',
                'csrf' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'message' => 'Paciente creado correctamente.',
            'patient' => [
                'id' => (int) $patient['id'],
                'name' => (string) $patient['name'],
                'client_id' => (int) $patient['client_id'],
            ],
            'csrf' => csrf_hash(),
        ]);
    }

    private function defaultFormData(?array $clientUser = null): array
    {
        return [
            'required_date'     => '',
            'client_id'         => isset($clientUser['id']) ? (int) $clientUser['id'] : '',
            'patient_id'        => '',
            'shade'             => '',
            'work_types'        => [],
            'selected_teeth'    => [],
            'restoration_types' => [],
            'implant_case'      => false,
            'implant_chimney'   => 'none',
            'attachments'       => [],
            'observations'      => '',
        ];
    }

    private function requestFormData(?array $clientUser = null): array
    {
        $implantCase = $this->request->getPost('implant_case') === '1';
        $clientId = isset($clientUser['id']) ? (int) $clientUser['id'] : (int) $this->request->getPost('client_id');

        return [
            'required_date'     => trim((string) $this->request->getPost('required_date')),
            'client_id'         => $clientId,
            'patient_id'        => (int) $this->request->getPost('patient_id'),
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
            'shade'          => 'permit_empty|max_length[50]',
            'observations'   => 'permit_empty|max_length[2000]',
        ];
    }

    private function customValidationErrors(array $formData, array $catalogs, string $minRequiredDate): array
    {
        $errors = [];
        $client = $this->findClientById($formData['client_id'], $catalogs['clients']);
        $patient = $this->findPatientById($formData['patient_id'], $catalogs['patients']);

        if ($formData['work_types'] === []) {
            $errors['work_types'] = 'Seleccione al menos un trabajo.';
        }

        if ($formData['selected_teeth'] === []) {
            $errors['selected_teeth'] = 'Seleccione al menos un diente.';
        }

        if ($client === null) {
            $errors['client_id'] = 'Seleccione un cliente válido.';
        }

        if ($patient === null) {
            $errors['patient_id'] = 'Seleccione un paciente válido.';
        } elseif ((int) ($patient['client_id'] ?? 0) !== (int) $formData['client_id']) {
            $errors['patient_id'] = 'El paciente no pertenece al cliente seleccionado.';
        }

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

    private function handleAttachmentsUpload(array &$attachments): ?string
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

        if (count($validFiles) > 5) {
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

    private function filterAllowedArray(array $values, array $allowed): array
    {
        $filtered = array_values(array_intersect($values, $allowed));

        return array_values(array_unique(array_map('strval', $filtered)));
    }

    private function loadCatalogs(?array $clientUser = null): array
    {
        $clientModel = new ClientModel();
        $patientModel = new PatientModel();

        if (is_array($clientUser) && isset($clientUser['id'])) {
            $clients = $clientModel
                ->where('is_active', 1)
                ->where('id', (int) $clientUser['id'])
                ->orderBy('name', 'ASC')
                ->findAll();

            $patients = $patientModel
                ->where('is_active', 1)
                ->where('client_id', (int) $clientUser['id'])
                ->orderBy('name', 'ASC')
                ->findAll();
        } else {
            $clients = $clientModel
                ->where('is_active', 1)
                ->orderBy('name', 'ASC')
                ->findAll();

            $patients = $patientModel
                ->where('is_active', 1)
                ->orderBy('name', 'ASC')
                ->findAll();
        }

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

    private function logModelFailure(string $context, array $errors): void
    {
        $message = $errors !== [] ? json_encode($errors, JSON_UNESCAPED_UNICODE) : 'unknown error';
        log_message('error', 'Database write failed during {context}: {message}', [
            'context' => $context,
            'message' => $message ?: 'unknown error',
        ]);
    }
}
