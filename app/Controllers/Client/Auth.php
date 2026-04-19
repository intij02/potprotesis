<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class Auth extends BaseController
{
    public function login()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        return view('client/auth/login', [
            'pageTitle' => 'Acceso Cliente - POT Prótesis Dental',
            'metaDescription' => 'Acceso de clientes para revisar el estatus de sus órdenes.',
        ]);
    }

    public function attempt()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        $rules = [
            'email' => 'required|valid_email|max_length[190]',
            'password' => 'required|min_length[6]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $client = (new ClientModel())->where('email', $email)->first();

        if (
            ! $client
            || ! (bool) $client['is_active']
            || empty($client['password_hash'])
            || ! password_verify($password, $client['password_hash'])
        ) {
            return redirect()->back()->withInput()->with('error', 'Email o contraseña inválidos.');
        }

        $this->session->set('client_user', [
            'id' => $client['id'],
            'name' => $client['name'],
            'email' => $client['email'],
        ]);

        return redirect()->to('/cliente/panel')->with('success', 'Sesión iniciada correctamente.');
    }

    public function logout()
    {
        $this->session->remove('client_user');
        $this->session->regenerate(true);

        return redirect()->to('/cliente/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
