<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use CodeIgniter\Email\Email;
use Config\Services;

class Pages extends BaseController
{
    public function servicios(): string
    {
        return view('pages/servicios', [
            'pageTitle' => 'Servicios - POT Prótesis Dental',
            'metaDescription' => 'Servicios profesionales de prótesis dental: coronas, puentes, prótesis removibles e implantes.',
            'services' => site_services(),
        ]);
    }

    public function galeria(): string
    {
        return view('pages/galeria', [
            'pageTitle' => 'Galería - POT Prótesis Dental',
            'metaDescription' => 'Galería de trabajos realizados por POT Prótesis Dental.',
            'galleryItems' => site_gallery_items(),
        ]);
    }

    public function contacto()
    {
        $validation = service('validation');
        $formStartedAt = session('contact_form_started_at');

        if (! is_int($formStartedAt)) {
            $formStartedAt = time();
            $this->session->set('contact_form_started_at', $formStartedAt);
        }

        $formData = [
            'name' => old('name', ''),
            'email' => old('email', ''),
            'phone' => old('phone', ''),
            'message' => old('message', ''),
            'website' => '',
        ];

        if ($this->request->getMethod() === 'POST') {
            $formData = [
                'name' => $this->sanitizeSingleLine((string) $this->request->getPost('name')),
                'email' => $this->sanitizeSingleLine((string) $this->request->getPost('email')),
                'phone' => $this->sanitizeSingleLine((string) $this->request->getPost('phone')),
                'message' => $this->sanitizeMessage((string) $this->request->getPost('message')),
                'website' => trim((string) $this->request->getPost('website')),
            ];

            $rules = [
                'name' => 'required|min_length[3]|max_length[140]|regex_match[/^[\p{L}\p{N}\s\.\-\'"]+$/u]',
                'email' => 'required|valid_email|max_length[190]',
                'phone' => 'permit_empty|max_length[30]|regex_match[/^[0-9\+\-\(\)\s]+$/]',
                'message' => 'required|min_length[10]|max_length[3000]',
            ];

            if ($validation->setRules($rules)->run($formData)) {
                $securityErrors = $this->contactSecurityErrors($formData, $formStartedAt);

                if ($securityErrors !== []) {
                    foreach ($securityErrors as $field => $message) {
                        $validation->setError($field, $message);
                    }

                    return view('pages/contacto', [
                        'pageTitle' => 'Contacto - POT Prótesis Dental',
                        'metaDescription' => 'Contáctenos por WhatsApp, teléfono o correo.',
                        'validation' => $validation,
                        'formData' => $formData,
                        'formStartedAt' => $formStartedAt,
                    ]);
                }

                (new ContactMessageModel())->insert([
                    'name' => $formData['name'],
                    'email' => $formData['email'],
                    'phone' => $formData['phone'] !== '' ? $formData['phone'] : null,
                    'message' => $formData['message'],
                    'is_read' => 0,
                ]);

                $this->recordContactSubmission();
                $this->sendContactNotification($formData);
                $this->session->set('contact_form_started_at', time());

                return redirect()->to('/contacto')->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto con usted.');
            }
        }

        return view('pages/contacto', [
            'pageTitle' => 'Contacto - POT Prótesis Dental',
            'metaDescription' => 'Contáctenos por WhatsApp, teléfono o correo.',
            'validation' => $validation,
            'formData' => $formData,
            'formStartedAt' => $formStartedAt,
        ]);
    }

    public function privacidad(): string
    {
        return view('pages/privacidad', [
            'pageTitle' => 'Privacidad - POT Prótesis Dental',
            'metaDescription' => 'Aviso de privacidad de POT Prótesis Dental.',
        ]);
    }

    public function terminos(): string
    {
        return view('pages/terminos', [
            'pageTitle' => 'Términos - POT Prótesis Dental',
            'metaDescription' => 'Términos y condiciones de POT Prótesis Dental.',
        ]);
    }

    private function sendContactNotification(array $formData): void
    {
        $recipient = site_setting('contact_form_recipient_email', site_setting('contact_email', config('Email')->fromEmail));

        if ($recipient === null || $recipient === '') {
            return;
        }

        try {
            /** @var Email $email */
            $email = service('email');
            $fromEmail = config('Email')->fromEmail !== '' ? config('Email')->fromEmail : $recipient;
            $fromName = config('Email')->fromName !== '' ? config('Email')->fromName : 'POT Prótesis Dental';

            $email->setFrom($fromEmail, $fromName);
            $email->setTo($recipient);
            $email->setReplyTo($formData['email'], $formData['name']);
            $email->setSubject('Nuevo mensaje desde el formulario de contacto');
            $email->setMessage(
                "Nombre: {$formData['name']}\n"
                . "Email: {$formData['email']}\n"
                . "Teléfono: " . ($formData['phone'] !== '' ? $formData['phone'] : 'No proporcionado') . "\n\n"
                . "Mensaje:\n{$formData['message']}"
            );
            $email->send(false);
        } catch (\Throwable) {
        }
    }

    private function sanitizeSingleLine(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace(["\r", "\n"], ' ', $value);

        return trim(preg_replace('/\s+/', ' ', $value) ?? '');
    }

    private function sanitizeMessage(string $value): string
    {
        $value = str_replace("\0", '', $value);
        $value = strip_tags($value);
        $value = preg_replace("/\r\n|\r|\n/", "\n", $value) ?? $value;

        return trim($value);
    }

    private function contactSecurityErrors(array $formData, int $formStartedAt): array
    {
        $errors = [];

        if ($formData['website'] !== '') {
            $errors['message'] = 'No fue posible procesar su mensaje.';
        }

        $elapsed = time() - $formStartedAt;

        if ($elapsed < 3) {
            $errors['message'] = 'Envío demasiado rápido. Intente nuevamente.';
        }

        if ($elapsed > 7200) {
            $errors['message'] = 'La sesión del formulario expiró. Recargue la página e intente nuevamente.';
        }

        if ($this->isContactRateLimited()) {
            $errors['message'] = 'Se alcanzó el límite temporal de envíos. Intente más tarde.';
        }

        return $errors;
    }

    private function isContactRateLimited(): bool
    {
        $cache = Services::cache();
        $ip = $this->request->getIPAddress() ?: 'unknown';
        $key = 'contact_rate_' . sha1($ip);
        $state = $cache->get($key);

        if (! is_array($state) || ! isset($state['count'], $state['first_at'])) {
            return false;
        }

        if ((time() - (int) $state['first_at']) > 3600) {
            return false;
        }

        return (int) $state['count'] >= 5;
    }

    private function recordContactSubmission(): void
    {
        $cache = Services::cache();
        $ip = $this->request->getIPAddress() ?: 'unknown';
        $key = 'contact_rate_' . sha1($ip);
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
}
