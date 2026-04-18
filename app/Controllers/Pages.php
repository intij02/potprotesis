<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use CodeIgniter\Email\Email;

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
        $formData = [
            'name' => old('name', ''),
            'email' => old('email', ''),
            'phone' => old('phone', ''),
            'message' => old('message', ''),
        ];

        if ($this->request->getMethod() === 'POST') {
            $formData = [
                'name' => trim((string) $this->request->getPost('name')),
                'email' => trim((string) $this->request->getPost('email')),
                'phone' => trim((string) $this->request->getPost('phone')),
                'message' => trim((string) $this->request->getPost('message')),
            ];

            $rules = [
                'name' => 'required|min_length[3]|max_length[140]',
                'email' => 'required|valid_email|max_length[190]',
                'phone' => 'permit_empty|max_length[30]',
                'message' => 'required|min_length[10]|max_length[3000]',
            ];

            if ($validation->setRules($rules)->run($formData)) {
                (new ContactMessageModel())->insert([
                    'name' => $formData['name'],
                    'email' => $formData['email'],
                    'phone' => $formData['phone'] !== '' ? $formData['phone'] : null,
                    'message' => $formData['message'],
                    'is_read' => 0,
                ]);

                $this->sendContactNotification($formData);

                return redirect()->to('/contacto')->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto con usted.');
            }
        }

        return view('pages/contacto', [
            'pageTitle' => 'Contacto - POT Prótesis Dental',
            'metaDescription' => 'Contáctenos por WhatsApp, teléfono o correo.',
            'validation' => $validation,
            'formData' => $formData,
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
}
