<?php

namespace App\Controllers;

use App\Models\BlogPostModel;
use App\Models\ContactMessageModel;
use App\Models\ServiceModel;
use CodeIgniter\Email\Email;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Pages extends BaseController
{
    public function servicios(): string
    {
        $services = site_services();

        return view('pages/servicios', [
            'pageTitle' => 'Servicios - POT Prótesis Dental',
            'metaDescription' => 'Servicios profesionales de prótesis dental: coronas, puentes, prótesis removibles e implantes.',
            'metaImage' => isset($services[0]['image_path']) && $services[0]['image_path'] !== ''
                ? base_url($services[0]['image_path'])
                : base_url('assets/media/logo-pot.png'),
            'services' => $services,
        ]);
    }

    public function blog(): string
    {
        $posts = site_blog_posts();

        return view('pages/blog', [
            'pageTitle' => 'Blog - POT Prótesis Dental',
            'metaDescription' => 'Artículos y contenido del laboratorio POT Prótesis Dental.',
            'metaImage' => isset($posts[0]['image_path']) && $posts[0]['image_path'] !== ''
                ? base_url($posts[0]['image_path'])
                : base_url('assets/media/logo-pot.png'),
            'posts' => $posts,
        ]);
    }

    public function blogDetalle(string $slug): string
    {
        $post = (new BlogPostModel())
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (! is_array($post)) {
            throw PageNotFoundException::forPageNotFound('Entrada no encontrada.');
        }

        $publishedAt = $this->toIso8601($post['created_at'] ?? null);
        $modifiedAt = $this->toIso8601($post['updated_at'] ?? ($post['created_at'] ?? null));
        $canonicalUrl = current_url();

        return view('pages/blog_detalle', [
            'pageTitle' => $post['title'] . ' - Blog POT Prótesis Dental',
            'metaDescription' => $this->plainExcerpt((string) $post['content'], 155),
            'metaImage' => ! empty($post['image_path']) ? base_url($post['image_path']) : base_url('assets/media/logo-pot.png'),
            'metaImageAlt' => $post['title'],
            'canonicalUrl' => $canonicalUrl,
            'ogType' => 'article',
            'twitterCard' => 'summary_large_image',
            'metaAuthor' => 'POT Prótesis Dental',
            'articlePublishedTime' => $publishedAt,
            'articleModifiedTime' => $modifiedAt,
            'schemaJson' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => (string) $post['title'],
                'description' => $this->plainExcerpt((string) $post['content'], 155),
                'datePublished' => $publishedAt,
                'dateModified' => $modifiedAt,
                'mainEntityOfPage' => $canonicalUrl,
                'author' => [
                    '@type' => 'Organization',
                    'name' => 'POT Prótesis Dental',
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'POT Prótesis Dental',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => base_url('assets/media/logo-pot.png'),
                    ],
                ],
                'image' => ! empty($post['image_path']) ? [base_url($post['image_path'])] : [base_url('assets/media/logo-pot.png')],
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'post' => $post,
        ]);
    }

    public function galeria(): string
    {
        $galleryItems = site_gallery_items();

        return view('pages/galeria', [
            'pageTitle' => 'Galería - POT Prótesis Dental',
            'metaDescription' => 'Galería de trabajos realizados por POT Prótesis Dental.',
            'metaImage' => isset($galleryItems[0]['image_path']) && $galleryItems[0]['image_path'] !== ''
                ? base_url($galleryItems[0]['image_path'])
                : base_url('assets/media/logo-pot.png'),
            'galleryItems' => $galleryItems,
        ]);
    }

    public function servicioDetalle(string $slug): string
    {
        $service = (new ServiceModel())
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (! is_array($service)) {
            throw PageNotFoundException::forPageNotFound('Servicio no encontrado.');
        }

        $detailImages = $this->serviceDetailImages($service);
        $canonicalUrl = current_url();
        $serviceDescription = $this->plainExcerpt((string) ($service['detail_content'] ?: $service['summary'] ?: ''), 155);

        return view('pages/servicio_detalle', [
            'pageTitle' => $service['title'] . ' - POT Prótesis Dental',
            'metaDescription' => $serviceDescription !== '' ? $serviceDescription : 'Detalle del servicio de POT Prótesis Dental.',
            'metaImage' => isset($detailImages[0]) ? base_url($detailImages[0]) : base_url('assets/media/logo-pot.png'),
            'metaImageAlt' => $service['title'],
            'canonicalUrl' => $canonicalUrl,
            'twitterCard' => 'summary_large_image',
            'metaAuthor' => 'POT Prótesis Dental',
            'schemaJson' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => (string) $service['title'],
                'description' => $serviceDescription !== '' ? $serviceDescription : 'Servicio de POT Prótesis Dental.',
                'url' => $canonicalUrl,
                'image' => array_map(
                    static fn (string $imagePath): string => base_url($imagePath),
                    $detailImages !== [] ? $detailImages : ['assets/media/logo-pot.png']
                ),
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'POT Prótesis Dental',
                    'url' => base_url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => base_url('assets/media/logo-pot.png'),
                    ],
                    'telephone' => site_setting('contact_phone_href', '+523334735108'),
                    'email' => site_setting('contact_email', 'contacto@potprotesisdental.com'),
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => site_setting('contact_address', 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.'),
                        'addressLocality' => 'Guadalajara',
                        'addressRegion' => 'Jalisco',
                        'addressCountry' => 'MX',
                    ],
                ],
                'areaServed' => [
                    '@type' => 'City',
                    'name' => 'Guadalajara',
                ],
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'service' => $service,
            'detailImages' => $detailImages,
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
            'metaDescription' => 'Aviso de privacidad integral de POT Prótesis Dental conforme a la legislación mexicana aplicable.',
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

    private function serviceDetailImages(array $service): array
    {
        $images = [];
        $rawImages = $service['detail_images'] ?? null;

        if (is_string($rawImages) && $rawImages !== '') {
            $decoded = json_decode($rawImages, true);

            if (is_array($decoded)) {
                foreach ($decoded as $path) {
                    if (is_string($path) && trim($path) !== '') {
                        $images[] = trim($path);
                    }
                }
            }
        }

        if ($images === [] && ! empty($service['image_path'])) {
            $images[] = (string) $service['image_path'];
        }

        return array_values(array_unique($images));
    }

    private function plainExcerpt(string $html, int $limit = 180): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)) ?? '');

        if ($text === '') {
            return 'Contenido del blog de POT Prótesis Dental.';
        }

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $limit - 1)) . '…';
    }

    private function toIso8601(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return null;
        }

        return date(DATE_ATOM, $timestamp);
    }
}
