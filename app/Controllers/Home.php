<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home', [
            'pageTitle' => 'POT Prótesis Dental - Laboratorio Profesional en Guadalajara',
            'metaDescription' => 'Laboratorio especializado en prótesis dental de alta calidad. Coronas, puentes e implantes para dentistas y clínicas en Guadalajara.',
        ]);
    }
}
