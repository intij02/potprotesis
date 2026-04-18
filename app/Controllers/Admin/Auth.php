<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (admin_is_logged_in()) {
            return redirect()->to('/admin/ordenes');
        }

        return view('admin/auth/login', [
            'pageTitle' => 'Admin Login - POT Prótesis Dental',
            'metaDescription' => 'Acceso administrativo para gestionar órdenes de laboratorio.',
        ]);
    }

    public function attempt()
    {
        if (admin_is_logged_in()) {
            return redirect()->to('/admin/ordenes');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[80]',
            'password' => 'required|min_length[6]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $adminUserModel = new AdminUserModel();
        $user = $adminUserModel->where('username', $username)->first();

        if (! $user || ! (bool) $user['is_active'] || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña inválidos.');
        }

        $this->session->set('admin_user', [
            'id'        => $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
            'role'      => $user['role'] ?? 'admin',
        ]);

        return redirect()->to('/admin/ordenes')->with('success', 'Sesión iniciada correctamente.');
    }

    public function logout()
    {
        $this->session->remove('admin_user');
        $this->session->regenerate(true);

        return redirect()->to('/admin/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
