<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\LabOrderModel;
use App\Models\PatientModel;

class Panel extends BaseController
{
    public function index()
    {
        $client = client_auth_user();
        $clientId = (int) ($client['id'] ?? 0);

        $orders = (new LabOrderModel())
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $patientModel = new PatientModel();
        $patientCount = $patientModel->where('client_id', $clientId)->countAllResults();

        return view('client/panel/index', [
            'pageTitle' => 'Panel de Cliente - POT Prótesis Dental',
            'metaDescription' => 'Consulta de órdenes y estatus para clientes.',
            'orders' => $orders,
            'client' => $client,
            'patientCount' => $patientCount,
        ]);
    }
}
