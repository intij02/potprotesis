<?php

namespace App\Filters;

use App\Models\ClientModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ClientAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        if (! client_is_logged_in()) {
            return redirect()->to('/cliente/login');
        }

        $sessionUser = client_auth_user();
        $client = (new ClientModel())->find((int) ($sessionUser['id'] ?? 0));

        if (! is_array($client) || ! (bool) ($client['is_active'] ?? false)) {
            session()->remove('client_user');
            session()->regenerate(true);

            return redirect()->to('/cliente/login')
                ->with('error', 'Su sesión ya no está autorizada.');
        }

        session()->set('client_user', [
            'id' => $client['id'],
            'name' => $client['name'],
            'email' => $client['email'],
            'is_active' => (bool) ($client['is_active'] ?? false),
        ]);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
