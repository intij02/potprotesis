<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\LabOrderModel;
use App\Models\PatientModel;

class Orders extends BaseController
{
    public function create()
    {
        $validation = service('validation');
        $clientUser = client_auth_user();
        $formData   = $this->defaultFormData($clientUser);
        $catalogs   = $this->loadCatalogs($clientUser);

        if ($this->request->getMethod() === 'post') {
            $formData   = $this->requestFormData($clientUser);
            $fieldRules = $this->fieldRules();

            if ($validation->setRules($fieldRules)->run($formData)) {
                $customErrors = $this->customValidationErrors($formData, null, $catalogs);

                if ($customErrors === []) {
                    $client = $this->findClientById($formData['client_id'], $catalogs['clients']);
                    $patient = $this->findPatientById($formData['patient_id'], $catalogs['patients']);
                    $model = new LabOrderModel();
                    $insertData = [
                        'order_number'      => null,
                        'sent_date'         => date('Y-m-d'),
                        'required_date'     => $formData['required_date'],
                        'client_id'         => $formData['client_id'],
                        'patient_id'        => $formData['patient_id'],
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
                        'observations'      => $formData['observations'] !== '' ? $formData['observations'] : null,
                        'signature_name'    => null,
                    ];

                    if (! $model->insert($insertData)) {
                        $this->logModelFailure('lab order insert', $model->errors());
                        $validation->setError('form', 'No fue posible guardar la orden en la base de datos.');
                    } else {
                        return redirect()->to('/orden-laboratorio')
                            ->with('success', 'La orden quedó registrada correctamente.');
                    }

                }

                foreach ($customErrors as $field => $message) {
                    $validation->setError($field, $message);
                }
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

        $referenceDate = $order !== null && ! empty($order['created_at'])
            ? date('Y-m-d', strtotime((string) $order['created_at']))
            : date('Y-m-d');

        if ($formData['required_date'] !== '' && $formData['required_date'] < $referenceDate) {
            $errors['required_date'] = 'La fecha requerida no puede ser anterior a la fecha de recepción.';
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
