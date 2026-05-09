<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use CodeIgniter\Email\Email;
use Config\Services;

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

        $formStartedAt = session('client_register_form_started_at');

        if (! is_int($formStartedAt) || (time() - $formStartedAt) > 7200) {
            $formStartedAt = time();
            $this->session->set('client_register_form_started_at', $formStartedAt);
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
            'is_active' => (bool) ($client['is_active'] ?? false),
        ]);

        return redirect()->to('/cliente/panel')->with('success', 'Sesión iniciada correctamente.');
    }

    public function store()
    {
        if (client_is_logged_in()) {
            return redirect()->to('/cliente/panel');
        }

        $this->purgeExpiredPendingClients();

        $validation = service('validation');
        $formStartedAt = session('client_register_form_started_at');
        $formData = [
            'name' => $this->sanitizeSingleLine((string) $this->request->getPost('name')),
            'contact_phone' => $this->sanitizeSingleLine((string) $this->request->getPost('contact_phone')),
            'email' => $this->sanitizeSingleLine((string) $this->request->getPost('email')),
            'website' => trim((string) $this->request->getPost('company_website')),
        ];

        $rules = [
            'name' => 'required|min_length[3]|max_length[160]|regex_match[/^[\p{L}\p{N}\s\.\-\'"&]+$/u]',
            'contact_phone' => 'permit_empty|max_length[30]|regex_match[/^[0-9\+\-\(\)\s]+$/]',
            'email' => 'required|valid_email|max_length[190]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $validation->setRules($rules)->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $securityErrors = $this->registrationSecurityErrors($formData, is_int($formStartedAt) ? $formStartedAt : 0);

        if ($securityErrors !== []) {
            log_message('warning', 'Client registration blocked by security checks: {context}', [
                'context' => json_encode($this->registrationSecurityContext($formData, is_int($formStartedAt) ? $formStartedAt : 0), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]);

            foreach ($securityErrors as $field => $message) {
                $validation->setError($field, $message);
            }

            return redirect()->back()->withInput()->with('error', reset($securityErrors) ?: 'No fue posible procesar el registro.');
        }

        $clientModel = new ClientModel();
        $email = $formData['email'];
        $existingClient = $clientModel->findByEmail($email);

        if ($existingClient && (bool) ($existingClient['is_active'] ?? false)) {
            return redirect()->back()->withInput()->with('error', 'Este email ya está registrado. Inicia sesión con tu cuenta.');
        }

        $token = bin2hex(random_bytes(32));
        $now = date('Y-m-d H:i:s');
        $clientData = [
            'name' => $formData['name'],
            'contact_phone' => $this->nullableString($formData['contact_phone']),
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

        $this->recordRegistrationSubmission();
        $this->session->set('client_register_form_started_at', time());

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

    private function sanitizeSingleLine(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace(["\r", "\n"], ' ', $value);

        return trim(preg_replace('/\s+/', ' ', $value) ?? '');
    }

    private function registrationSecurityErrors(array $formData, int $formStartedAt): array
    {
        $errors = [];

        if ($formData['website'] !== '') {
            $errors['name'] = 'No fue posible procesar el registro.';
        }

        if ($formStartedAt <= 0) {
            $errors['name'] = 'La sesión del formulario expiró. Recarga la página e intenta nuevamente.';
        } else {
            $elapsed = time() - $formStartedAt;

            if ($elapsed < 4) {
                $errors['name'] = 'Envío demasiado rápido. Intenta nuevamente.';
            }

            if ($elapsed > 7200) {
                $errors['name'] = 'La sesión del formulario expiró. Recarga la página e intenta nuevamente.';
            }
        }

        if ($this->looksLikeSpamRegistration($formData)) {
            $errors['name'] = 'No fue posible procesar el registro.';
        }

        if ($this->isRegistrationRateLimited()) {
            $errors['email'] = 'Se alcanzó el límite temporal de registros desde esta red. Intenta más tarde.';
        }

        return $errors;
    }

    private function registrationSecurityContext(array $formData, int $formStartedAt): array
    {
        $email = $formData['email'];
        $localPart = strstr($email, '@', true);

        return [
            'ip' => $this->request->getIPAddress(),
            'user_agent' => (string) $this->request->getUserAgent(),
            'email' => $this->maskEmailForLog($email),
            'honeypot_filled' => $formData['website'] !== '',
            'honeypot_length' => strlen($formData['website']),
            'form_started_at' => $formStartedAt,
            'elapsed_seconds' => $formStartedAt > 0 ? time() - $formStartedAt : null,
            'looks_like_spam' => $this->looksLikeSpamRegistration($formData),
            'rate_limited' => $this->isRegistrationRateLimited(),
            'name_has_url' => preg_match('/https?:\/\/|www\.|<|>|\[url|\[link/i', $formData['name']) === 1,
            'name_has_repeated_chars' => preg_match('/(.)\1{5,}/u', $formData['name']) === 1,
            'name_digit_count' => preg_match_all('/\d/', $formData['name']) ?: 0,
            'email_local_part_suspicious' => $localPart !== false && strlen($localPart) >= 18 && preg_match('/\d{5,}/', $localPart) === 1,
        ];
    }

    private function maskEmailForLog(string $email): string
    {
        $email = trim($email);

        if ($email === '' || strpos($email, '@') === false) {
            return $email;
        }

        [$localPart, $domain] = explode('@', $email, 2);

        if ($localPart === '') {
            return '*@' . $domain;
        }

        if (strlen($localPart) <= 2) {
            return substr($localPart, 0, 1) . '*@' . $domain;
        }

        return substr($localPart, 0, 2) . str_repeat('*', max(strlen($localPart) - 2, 1)) . '@' . $domain;
    }

    private function looksLikeSpamRegistration(array $formData): bool
    {
        $name = $formData['name'];
        $email = $formData['email'];

        if ($name === '' || $email === '') {
            return true;
        }

        if (preg_match('/https?:\/\/|www\.|<|>|\[url|\[link/i', $name) === 1) {
            return true;
        }

        if (preg_match('/(.)\1{5,}/u', $name) === 1) {
            return true;
        }

        $digitsInName = preg_match_all('/\d/', $name);

        if ($digitsInName !== false && $digitsInName >= 6) {
            return true;
        }

        $localPart = strstr($email, '@', true);

        if ($localPart === false) {
            return true;
        }

        if (strlen($localPart) >= 18 && preg_match('/\d{5,}/', $localPart) === 1) {
            return true;
        }

        return false;
    }

    private function isRegistrationRateLimited(): bool
    {
        $cache = Services::cache();
        $ip = $this->request->getIPAddress() ?: 'unknown';
        $key = 'client_register_rate_' . sha1($ip);
        $state = $cache->get($key);

        if (! is_array($state) || ! isset($state['count'], $state['first_at'])) {
            return false;
        }

        if ((time() - (int) $state['first_at']) > 3600) {
            return false;
        }

        return (int) $state['count'] >= 3;
    }

    private function recordRegistrationSubmission(): void
    {
        $cache = Services::cache();
        $ip = $this->request->getIPAddress() ?: 'unknown';
        $key = 'client_register_rate_' . sha1($ip);
        $state = $cache->get($key);
        $now = time();

        if (! is_array($state) || ! isset($state['count'], $state['first_at']) || (($now - (int) $state['first_at']) > 3600)) {
            $state = [
                'count' => 1,
                'first_at' => $now,
            ];
        } else {
            $state['count'] = (int) $state['count'] + 1;
        }

        $cache->save($key, $state, 3600);
    }

    private function purgeExpiredPendingClients(): void
    {
        $threshold = date('Y-m-d H:i:s', time() - 172800);

        $builder = (new ClientModel())
            ->withDeleted()
            ->where('is_active', 0)
            ->where('email_verified_at', null)
            ->where('email_verification_token IS NOT NULL', null, false)
            ->groupStart()
                ->where('email_verification_sent_at <', $threshold)
                ->orWhere('created_at <', $threshold)
            ->groupEnd();

        $rows = $builder->findAll();

        if ($rows === []) {
            return;
        }

        foreach ($rows as $row) {
            $clientId = (int) ($row['id'] ?? 0);

            if ($clientId <= 0 || $this->clientHasRelations($clientId)) {
                continue;
            }

            (new ClientModel())->delete($clientId, true);
        }
    }

    private function clientHasRelations(int $clientId): bool
    {
        if ($clientId <= 0) {
            return false;
        }

        $patientCount = (int) model('PatientModel')->withDeleted()->where('client_id', $clientId)->countAllResults();

        if ($patientCount > 0) {
            return true;
        }

        return (int) model('LabOrderModel')->withDeleted()->where('client_id', $clientId)->countAllResults() > 0;
    }
}
