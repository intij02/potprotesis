<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Patients extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new PatientModel();
        $model->where('client_id', $this->clientId());

        if ($query !== '') {
            $model->groupStart()
                ->like('name', $query)
                ->orLike('notes', $query)
                ->groupEnd();
        }

        return view('client/patients/index', [
            'pageTitle' => 'Mis Pacientes - POT Prótesis Dental',
            'metaDescription' => 'Gestión de pacientes para clientes de POT Prótesis Dental.',
            'patients' => $model->orderBy('name', 'ASC')->findAll(),
            'searchQuery' => $query,
            'client' => client_auth_user(),
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

        return redirect()->to('/cliente/pacientes')->with('success', 'Paciente creado correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOwnedOrFail($id), true);
    }

    public function update(int $id)
    {
        $this->findOwnedOrFail($id);

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new PatientModel())->update($id, $this->requestData());

        return redirect()->to('/cliente/pacientes')->with('success', 'Paciente actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $this->findOwnedOrFail($id);
        (new PatientModel())->delete($id);

        return redirect()->to('/cliente/pacientes')->with('success', 'Paciente eliminado correctamente.');
    }

    private function renderForm(?array $patient, bool $isEdit): string
    {
        return view('client/patients/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nuevo') . ' Paciente - POT Prótesis Dental',
            'metaDescription' => 'Formulario de pacientes del cliente.',
            'patient' => $patient,
            'isEdit' => $isEdit,
            'client' => client_auth_user(),
        ]);
    }

    private function requestData(): array
    {
        return [
            'client_id' => $this->clientId(),
            'name' => trim((string) $this->request->getPost('name')),
            'notes' => trim((string) $this->request->getPost('notes')) ?: null,
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];
    }

    private function rules(): array
    {
        return [
            'name' => 'required|min_length[3]|max_length[160]',
            'notes' => 'permit_empty|max_length[2000]',
        ];
    }

    private function findOwnedOrFail(int $id): array
    {
        $patient = (new PatientModel())
            ->where('client_id', $this->clientId())
            ->where('id', $id)
            ->first();

        if (! is_array($patient)) {
            throw PageNotFoundException::forPageNotFound('Paciente no encontrado.');
        }

        return $patient;
    }

    private function clientId(): int
    {
        return (int) (client_auth_user()['id'] ?? 0);
    }
}
