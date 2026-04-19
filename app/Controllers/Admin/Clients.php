<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Clients extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new ClientModel();

        if ($query !== '') {
            $model->groupStart()
                ->like('name', $query)
                ->orLike('contact_phone', $query)
                ->orLike('email', $query)
                ->groupEnd();
        }

        return view('admin/clients/index', [
            'pageTitle' => 'Clientes - Admin POT',
            'metaDescription' => 'Gestión de clientes y dentistas.',
            'clients' => $model->orderBy('name', 'ASC')->findAll(),
            'searchQuery' => $query,
        ]);
    }

    public function create(): string
    {
        return $this->renderForm(null, false);
    }

    public function store()
    {
        if (! $this->validate($this->rules(true))) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new ClientModel())->insert($this->requestData());

        return redirect()->to('/admin/clientes')->with('success', 'Cliente creado correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOrFail($id), true);
    }

    public function update(int $id)
    {
        $this->findOrFail($id);

        if (! $this->validate($this->rules(false))) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new ClientModel())->update($id, $this->requestData());

        return redirect()->to('/admin/clientes')->with('success', 'Cliente actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        (new ClientModel())->delete($id);

        return redirect()->to('/admin/clientes')->with('success', 'Cliente eliminado correctamente.');
    }

    private function renderForm(?array $client, bool $isEdit): string
    {
        return view('admin/clients/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nuevo') . ' Cliente - Admin POT',
            'metaDescription' => 'Formulario de clientes.',
            'client' => $client,
            'isEdit' => $isEdit,
        ]);
    }

    private function requestData(): array
    {
        $password = (string) $this->request->getPost('password');

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'contact_phone' => trim((string) $this->request->getPost('contact_phone')) ?: null,
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'notes' => trim((string) $this->request->getPost('notes')) ?: null,
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];

        if ($password !== '') {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        return $data;
    }

    private function rules(bool $requirePassword): array
    {
        return [
            'name' => 'required|min_length[3]|max_length[160]',
            'contact_phone' => 'permit_empty|max_length[30]',
            'email' => 'required|valid_email|max_length[190]',
            'password' => $requirePassword ? 'required|min_length[6]|max_length[255]' : 'permit_empty|min_length[6]|max_length[255]',
            'notes' => 'permit_empty|max_length[2000]',
        ];
    }

    private function findOrFail(int $id): array
    {
        $client = (new ClientModel())->find($id);

        if (! is_array($client)) {
            throw PageNotFoundException::forPageNotFound('Cliente no encontrado.');
        }

        return $client;
    }
}
