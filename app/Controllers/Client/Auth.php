<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use CodeIgniter\Email\Email;

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

    public function register()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        return view('client/auth/register', [
            'pageTitle' => 'Registro Cliente - POT Prótesis Dental',
            'metaDescription' => 'Registro de nuevos clientes para acceso al panel de POT Prótesis Dental.',
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

        $client = (new ClientModel())->findByEmail($email);

        if ($client && (! (bool) $client['is_active']) && ! empty($client['email_verification_token'])) {
            return redirect()->back()->withInput()->with('error', 'Tu cuenta aún no está activada. Revisa tu correo y confirma tu email.');
        }

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

    public function store()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[160]',
            'contact_phone' => 'permit_empty|max_length[30]|regex_match[/^[0-9\+\-\(\)\s]+$/]',
            'email' => 'required|valid_email|max_length[190]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $clientModel = new ClientModel();
        $email = trim((string) $this->request->getPost('email'));
        $existingClient = $clientModel->findByEmail($email);

        if ($existingClient && (bool) ($existingClient['is_active'] ?? false)) {
            return redirect()->back()->withInput()->with('error', 'Este email ya está registrado. Inicia sesión con tu cuenta.');
        }

        $token = bin2hex(random_bytes(32));
        $now = date('Y-m-d H:i:s');
        $clientData = [
            'name' => trim((string) $this->request->getPost('name')),
            'contact_phone' => $this->nullableString((string) $this->request->getPost('contact_phone')),
            'email' => $email,
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'email_verification_token' => $token,
            'email_verification_sent_at' => $now,
            'email_verified_at' => null,
            'is_active' => 0,
        ];
        $isNewClient = ! $existingClient;

        if ($existingClient) {
            $clientModel->update($existingClient['id'], $clientData);
            $clientId = (int) $existingClient['id'];
        } else {
            $clientModel->insert($clientData);
            $clientId = (int) $clientModel->getInsertID();
        }

        if ($clientId <= 0) {
            return redirect()->back()->withInput()->with('error', 'No fue posible crear la cuenta. Intenta nuevamente.');
        }

        if (! $this->sendActivationEmail($clientData['name'], $email, $token)) {
            if ($isNewClient) {
                $clientModel->delete($clientId, true);
            }

            return redirect()->back()->withInput()->with('error', 'No fue posible enviar el correo de activación. Verifica la configuración de email e intenta nuevamente.');
        }

        return redirect()->to('/cliente/login')->with('success', 'Tu registro fue creado. Revisa tu correo para activar la cuenta.');
    }

    public function activate()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        $token = trim((string) $this->request->getGet('token'));

        if ($token === '') {
            return redirect()->to('/cliente/login')->with('error', 'El enlace de activación no es válido.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->where('email_verification_token', $token)->first();

        if (! $client) {
            return redirect()->to('/cliente/login')->with('error', 'El enlace de activación es inválido o ya fue utilizado.');
        }

        $clientModel->update($client['id'], [
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_verification_token' => null,
            'email_verification_sent_at' => null,
        ]);

        return redirect()->to('/cliente/login')->with('success', 'Tu cuenta fue activada correctamente. Ya puedes iniciar sesión.');
    }

    public function logout()
    {
        $this->session->remove('client_user');
        $this->session->regenerate(true);

        return redirect()->to('/cliente/login')->with('success', 'Sesión cerrada correctamente.');
    }

    private function sendActivationEmail(string $name, string $emailAddress, string $token): bool
    {
        try {
            /** @var Email $email */
            $email = service('email');
            $fromEmail = config('Email')->fromEmail !== '' ? config('Email')->fromEmail : 'no-reply@localhost';
            $fromName = config('Email')->fromName !== '' ? config('Email')->fromName : 'POT Prótesis Dental';
            $activationUrl = base_url('cliente/activar?token=' . rawurlencode($token));
            $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $safeActivationUrl = htmlspecialchars($activationUrl, ENT_QUOTES, 'UTF-8');
            $htmlMessage = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activa tu cuenta</title>
</head>
<body style="margin:0;padding:24px;background:#f4f6fb;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;border-collapse:collapse;background:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #dbe3ef;">
                    <tr>
                        <td style="padding:32px 36px;background:#3a4154;color:#ffffff;">
                            <div style="font-size:13px;letter-spacing:0.08em;text-transform:uppercase;opacity:0.82;">POT Prótesis Dental</div>
                            <h1 style="margin:12px 0 0;font-size:28px;line-height:1.15;font-weight:700;">Activa tu cuenta de cliente</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 36px;">
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">Hola {$safeName},</p>
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">Gracias por registrarte en POT Prótesis Dental. Para completar tu acceso y activar tu cuenta, confirma tu email desde el siguiente botón:</p>
                            <table role="presentation" cellspacing="0" cellpadding="0" style="margin:28px 0;border-collapse:collapse;">
                                <tr>
                                    <td style="border-radius:999px;background:#fecd0a;">
                                        <a href="{$safeActivationUrl}" style="display:inline-block;padding:14px 24px;font-size:15px;font-weight:700;line-height:1;color:#574600;text-decoration:none;">Activar mi cuenta</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 14px;font-size:14px;line-height:1.7;color:#4b5563;">Si el botón no funciona, copia y pega esta dirección en tu navegador:</p>
                            <p style="margin:0 0 22px;font-size:14px;line-height:1.7;word-break:break-all;"><a href="{$safeActivationUrl}" style="color:#2563eb;text-decoration:underline;">{$safeActivationUrl}</a></p>
                            <p style="margin:0;font-size:14px;line-height:1.7;color:#6b7280;">Si no solicitaste este registro, puedes ignorar este mensaje.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
            $textMessage =
                "Hola {$name},\n\n"
                . "Gracias por registrarte en POT Prótesis Dental.\n"
                . "Para activar tu cuenta visita el siguiente enlace:\n\n"
                . "{$activationUrl}\n\n"
                . "Si no solicitaste este registro, puedes ignorar este mensaje.";

            $email->setFrom($fromEmail, $fromName);
            $email->setTo($emailAddress);
            $email->setSubject('Activa tu cuenta de cliente');
            $email->setMessage($htmlMessage);
            $email->setAltMessage($textMessage);

            return $email->send(false);
        } catch (\Throwable) {
            return false;
        }
    }

    private function nullableString(string $value): ?string
    {
        $value = trim($value);

        return $value !== '' ? $value : null;
    }
}
