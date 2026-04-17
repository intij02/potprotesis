<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function servicios(): string
    {
        return view('pages/servicios', [
            'pageTitle' => 'Servicios - POT Prótesis Dental',
            'metaDescription' => 'Servicios profesionales de prótesis dental: coronas, puentes, prótesis removibles e implantes.',
        ]);
    }

    public function galeria(): string
    {
        return view('pages/galeria', [
            'pageTitle' => 'Galería - POT Prótesis Dental',
            'metaDescription' => 'Galería de trabajos realizados por POT Prótesis Dental.',
        ]);
    }

    public function contacto(): string
    {
        return view('pages/contacto', [
            'pageTitle' => 'Contacto - POT Prótesis Dental',
            'metaDescription' => 'Contáctenos por WhatsApp, teléfono o correo.',
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
}
