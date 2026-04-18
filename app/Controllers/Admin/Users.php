<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new AdminUserModel();

        if ($query !== '') {
            $model
                ->groupStart()
                ->like('username', $query)
                ->orLike('full_name', $query)
                ->orLike('role', $query)
                ->groupEnd();
        }

        $users = $model->orderBy('created_at', 'DESC')->findAll();

        return view('admin/users/index', [
            'pageTitle'       => 'Usuarios Admin - POT Prótesis Dental',
            'metaDescription' => 'Gestión de usuarios administrativos y permisos.',
            'users'           => $users,
            'searchQuery'     => $query,
            'roleLabels'      => $this->roleLabels(),
        ]);
    }

    public function create(): string
    {
        return view('admin/users/form', [
            'pageTitle'       => 'Nuevo Usuario - POT Prótesis Dental',
            'metaDescription' => 'Alta de usuarios administrativos.',
            'user'            => null,
            'roleOptions'     => $this->roleLabels(),
            'isEdit'          => false,
        ]);
    }

    public function store()
    {
        $model = new AdminUserModel();
        $data  = $this->requestUserData();

        if (! $this->validate($this->userRules(false))) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        if ($this->usernameExists($data['username'])) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya existe.');
        }

        $model->insert([
            'username'      => $data['username'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'full_name'     => $data['full_name'],
            'role'          => $data['role'],
            'is_active'     => $data['is_active'] ? 1 : 0,
        ]);

        return redirect()->to('/admin/usuarios')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(int $id): string
    {
        $user = $this->findUserOrFail($id);

        return view('admin/users/form', [
            'pageTitle'       => 'Editar Usuario - POT Prótesis Dental',
            'metaDescription' => 'Actualización de usuarios administrativos.',
            'user'            => $user,
            'roleOptions'     => $this->roleLabels(),
            'isEdit'          => true,
        ]);
    }

    public function update(int $id)
    {
        $model = new AdminUserModel();
        $user  = $this->findUserOrFail($id);
        $data  = $this->requestUserData();

        if (! $this->validate($this->userRules(true))) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        if ($this->usernameExists($data['username'], $id)) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya existe.');
        }

        if ($this->wouldRemoveLastActiveAdmin($user, $data['role'], $data['is_active'])) {
            return redirect()->back()->withInput()->with('error', 'Debe conservar al menos un administrador activo.');
        }

        $payload = [
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'role'      => $data['role'],
            'is_active' => $data['is_active'] ? 1 : 0,
        ];

        if ($data['password'] !== '') {
            $payload['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $model->update($id, $payload);

        $sessionUser = $this->session->get('admin_user');

        if ((int) ($sessionUser['id'] ?? 0) === $id) {
            if (! $payload['is_active']) {
                $this->session->remove('admin_user');
                $this->session->regenerate(true);

                return redirect()->to('/admin/login')->with('success', 'Su usuario quedó inactivo. Inicie sesión nuevamente con una cuenta activa.');
            }

            $updatedSessionUser = array_merge(
                $sessionUser,
                [
                    'username'  => $payload['username'],
                    'full_name' => $payload['full_name'],
                    'role'      => $payload['role'],
                ]
            );

            $this->session->set('admin_user', $updatedSessionUser);

            if ($payload['role'] !== 'admin') {
                return redirect()->to('/admin/ordenes')->with('success', 'Usuario actualizado. Sus permisos ahora son de solo consulta.');
            }
        }

        return redirect()->to('/admin/usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $model = new AdminUserModel();
        $user  = $this->findUserOrFail($id);
        $sessionUser = $this->session->get('admin_user');
        $currentUserId = (int) ($sessionUser['id'] ?? 0);

        if ($currentUserId === $id) {
            return redirect()->to('/admin/usuarios')->with('error', 'No puede eliminar su propio usuario.');
        }

        if ($this->wouldRemoveLastActiveAdmin($user, 'staff', false)) {
            return redirect()->to('/admin/usuarios')->with('error', 'Debe conservar al menos un administrador activo.');
        }

        $model->delete($id);

        return redirect()->to('/admin/usuarios')->with('success', 'Usuario eliminado correctamente.');
    }

    private function findUserOrFail(int $id): array
    {
        $user = (new AdminUserModel())->find($id);

        if (! is_array($user)) {
            throw PageNotFoundException::forPageNotFound('Usuario no encontrado.');
        }

        return $user;
    }

    private function requestUserData(): array
    {
        $role = trim((string) $this->request->getPost('role'));

        return [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'password'  => (string) $this->request->getPost('password'),
            'role'      => array_key_exists($role, $this->roleLabels()) ? $role : 'staff',
            'is_active' => $this->request->getPost('is_active') === '1',
        ];
    }

    private function userRules(bool $isEdit): array
    {
        return [
            'username'  => 'required|min_length[3]|max_length[80]',
            'full_name' => 'required|min_length[3]|max_length[120]',
            'password'  => $isEdit ? 'permit_empty|min_length[6]|max_length[255]' : 'required|min_length[6]|max_length[255]',
            'role'      => 'required|in_list[admin,staff]',
        ];
    }

    private function usernameExists(string $username, ?int $excludeId = null): bool
    {
        $model = new AdminUserModel();
        $model->where('username', $username);

        if ($excludeId !== null) {
            $model->where('id !=', $excludeId);
        }

        return $model->first() !== null;
    }

    private function wouldRemoveLastActiveAdmin(array $user, string $newRole, bool $newIsActive): bool
    {
        $isCurrentActiveAdmin = ($user['role'] ?? 'admin') === 'admin' && (bool) ($user['is_active'] ?? false) === true;
        $remainsActiveAdmin   = $newRole === 'admin' && $newIsActive;

        if (! $isCurrentActiveAdmin || $remainsActiveAdmin) {
            return false;
        }

        $remainingAdmins = (new AdminUserModel())
            ->where('role', 'admin')
            ->where('is_active', 1)
            ->where('id !=', $user['id'])
            ->countAllResults();

        return $remainingAdmins === 0;
    }

    private function roleLabels(): array
    {
        return [
            'admin' => 'Administrador',
            'staff' => 'Consulta',
        ];
    }
}
