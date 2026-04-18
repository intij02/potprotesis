<?php

namespace App\Filters;

use App\Models\AdminUserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        if (! admin_is_logged_in()) {
            return redirect()->to('/admin/login');
        }

        $sessionUser = admin_auth_user();
        $user = (new AdminUserModel())->find((int) ($sessionUser['id'] ?? 0));

        if (! is_array($user) || ! (bool) ($user['is_active'] ?? false)) {
            session()->remove('admin_user');
            session()->regenerate(true);

            return redirect()->to('/admin/login')
                ->with('error', 'Su sesión ya no está autorizada.');
        }

        session()->set('admin_user', [
            'id'        => $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
            'role'      => $user['role'] ?? 'staff',
        ]);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
