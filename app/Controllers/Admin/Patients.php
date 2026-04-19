<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\PatientModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Patients extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new PatientModel();

        if ($query !== '') {
            $model->like('name', $query);
        }

        $patients = $model->orderBy('name', 'ASC')->findAll();
        $clientNames = $this->clientNameMap();

        return view('admin/patients/index', [
            'pageTitle' => 'Pacientes - Admin POT',
            'metaDescription' => 'Gestión de pacientes por cliente.',
            'patients' => $patients,
            'clientNames' => $clientNames,
            'searchQuery' => $query,
        ]);
    }

    public function create(): string
    {
        return $this->renderForm(null, false);
    }

    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new PatientModel())->insert($this->requestData());

        return redirect()->to('/admin/pacientes')->with('success', 'Paciente creado correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOrFail($id), true);
    }

    public function update(int $id)
    {
        $this->findOrFail($id);

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new PatientModel())->update($id, $this->requestData());

        return redirect()->to('/admin/pacientes')->with('success', 'Paciente actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        (new PatientModel())->delete($id);

        return redirect()->to('/admin/pacientes')->with('success', 'Paciente eliminado correctamente.');
    }

    private function renderForm(?array $patient, bool $isEdit): string
    {
        return view('admin/patients/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nuevo') . ' Paciente - Admin POT',
            'metaDescription' => 'Formulario de pacientes.',
            'patient' => $patient,
            'isEdit' => $isEdit,
            'clients' => (new ClientModel())->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    private function requestData(): array
    {
        return [
            'client_id' => (int) $this->request->getPost('client_id'),
            'name' => trim((string) $this->request->getPost('name')),
            'notes' => trim((string) $this->request->getPost('notes')) ?: null,
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];
    }

    private function rules(): array
    {
        return [
            'client_id' => 'required|integer|greater_than[0]',
            'name' => 'required|min_length[3]|max_length[160]',
            'notes' => 'permit_empty|max_length[2000]',
        ];
    }

    private function findOrFail(int $id): array
    {
        $patient = (new PatientModel())->find($id);

        if (! is_array($patient)) {
            throw PageNotFoundException::forPageNotFound('Paciente no encontrado.');
        }

        return $patient;
    }

    private function clientNameMap(): array
    {
        $map = [];

        foreach ((new ClientModel())->findAll() as $client) {
            $map[(int) $client['id']] = (string) $client['name'];
        }

        return $map;
    }
}
