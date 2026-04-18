<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LabOrderModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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

    public function update(int $id)
    {
        $order      = $this->findOrderOrFail($id);
        $validation = service('validation');
        $formData   = $this->requestFormData();

        if (! $validation->setRules($this->fieldRules())->run($formData)) {
            return $this->renderForm(array_merge($order, $formData), $validation);
        }

        $customErrors = $this->customValidationErrors($formData);

        if ($customErrors !== []) {
            foreach ($customErrors as $field => $message) {
                $validation->setError($field, $message);
            }

            return $this->renderForm(array_merge($order, $formData), $validation);
        }

        (new LabOrderModel())->update($id, [
            'order_number'      => $formData['order_number'] !== '' ? $formData['order_number'] : null,
            'sent_date'         => $formData['sent_date'],
            'required_date'     => $formData['required_date'],
            'dentist_name'      => $formData['dentist_name'],
            'patient_name'      => $formData['patient_name'],
            'contact_phone'     => $formData['contact_phone'],
            'shade'             => $formData['shade'] !== '' ? $formData['shade'] : null,
            'work_types'        => json_encode($formData['work_types'], JSON_UNESCAPED_UNICODE),
            'selected_teeth'    => json_encode($formData['selected_teeth'], JSON_UNESCAPED_UNICODE),
            'restoration_types' => json_encode($formData['restoration_types'], JSON_UNESCAPED_UNICODE),
            'implant_case'      => $formData['implant_case'] ? 1 : 0,
            'implant_chimney'   => $formData['implant_chimney'],
            'observations'      => $formData['observations'] !== '' ? $formData['observations'] : null,
            'signature_name'    => $formData['signature_name'] !== '' ? $formData['signature_name'] : null,
        ]);

        return redirect()->to('/admin/ordenes')->with('success', 'Orden actualizada correctamente.');
    }

    private function renderForm(array $order, $validation): string
    {
        return view('admin/orders/form', [
            'pageTitle'        => 'Editar Orden - POT Prótesis Dental',
            'metaDescription'  => 'Edición administrativa de órdenes.',
            'order'            => $this->mapOrderToFormData($order),
            'validation'       => $validation,
            'workTypes'        => pot_work_types(),
            'restorationTypes' => pot_restoration_types(),
            'upperTeeth'       => pot_upper_teeth(),
            'lowerTeeth'       => pot_lower_teeth(),
            'implantOptions'   => pot_implant_chimney_options(),
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
            'dentist_name'      => (string) ($order['dentist_name'] ?? ''),
            'patient_name'      => (string) ($order['patient_name'] ?? ''),
            'contact_phone'     => (string) ($order['contact_phone'] ?? ''),
            'shade'             => (string) ($order['shade'] ?? ''),
            'work_types'        => is_array($order['work_types'] ?? null) ? $order['work_types'] : [],
            'selected_teeth'    => is_array($order['selected_teeth'] ?? null) ? $order['selected_teeth'] : [],
            'restoration_types' => is_array($order['restoration_types'] ?? null) ? $order['restoration_types'] : [],
            'implant_case'      => (bool) ($order['implant_case'] ?? false),
            'implant_chimney'   => (string) ($order['implant_chimney'] ?? 'none'),
            'observations'      => (string) ($order['observations'] ?? ''),
            'signature_name'    => (string) ($order['signature_name'] ?? ''),
            'created_at'        => (string) ($order['created_at'] ?? ''),
        ];
    }

    private function requestFormData(): array
    {
        $implantCase = $this->request->getPost('implant_case') === '1';

        return [
            'order_number'      => trim((string) $this->request->getPost('order_number')),
            'sent_date'         => trim((string) $this->request->getPost('sent_date')),
            'required_date'     => trim((string) $this->request->getPost('required_date')),
            'dentist_name'      => trim((string) $this->request->getPost('dentist_name')),
            'patient_name'      => trim((string) $this->request->getPost('patient_name')),
            'contact_phone'     => trim((string) $this->request->getPost('contact_phone')),
            'shade'             => trim((string) $this->request->getPost('shade')),
            'work_types'        => $this->filterAllowedArray((array) $this->request->getPost('work_types'), pot_work_types()),
            'selected_teeth'    => $this->filterAllowedArray((array) $this->request->getPost('selected_teeth'), pot_all_teeth()),
            'restoration_types' => $this->filterAllowedArray((array) $this->request->getPost('restoration_types'), pot_restoration_types()),
            'implant_case'      => $implantCase,
            'implant_chimney'   => trim((string) $this->request->getPost('implant_chimney')) ?: 'none',
            'observations'      => trim((string) $this->request->getPost('observations')),
            'signature_name'    => trim((string) $this->request->getPost('signature_name')),
        ];
    }

    private function fieldRules(): array
    {
        return [
            'order_number'   => 'permit_empty|max_length[50]',
            'sent_date'      => 'required|valid_date[Y-m-d]',
            'required_date'  => 'required|valid_date[Y-m-d]',
            'dentist_name'   => 'required|min_length[3]|max_length[120]',
            'patient_name'   => 'required|min_length[3]|max_length[120]',
            'contact_phone'  => 'required|min_length[8]|max_length[30]',
            'shade'          => 'permit_empty|max_length[50]',
            'observations'   => 'permit_empty|max_length[2000]',
            'signature_name' => 'permit_empty|max_length[120]',
        ];
    }

    private function customValidationErrors(array $formData): array
    {
        $errors = [];

        if ($formData['work_types'] === []) {
            $errors['work_types'] = 'Seleccione al menos un trabajo.';
        }

        if ($formData['selected_teeth'] === []) {
            $errors['selected_teeth'] = 'Seleccione al menos un diente.';
        }

        if ($formData['required_date'] !== '' && $formData['sent_date'] !== '' && $formData['required_date'] < $formData['sent_date']) {
            $errors['required_date'] = 'La fecha requerida no puede ser anterior a la fecha de envío.';
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
}
