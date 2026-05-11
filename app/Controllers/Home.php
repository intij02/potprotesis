<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $services = site_services(true, 3);
        $galleryItems = site_gallery_items(true, 3);

        return view('pages/home', [
            'pageTitle' => 'POT Prótesis Dental - Laboratorio Profesional en Guadalajara',
            'metaDescription' => 'Laboratorio especializado en prótesis dental de alta calidad. Coronas, puentes e implantes para dentistas y clínicas en Guadalajara.',
            'metaImage' => base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg'),
            'services' => $services,
            'galleryItems' => $galleryItems,
        ]);
    }
}
