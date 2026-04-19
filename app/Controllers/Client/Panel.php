<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\LabOrderModel;

class Panel extends BaseController
{
    public function index()
    {
        $client = client_auth_user();

        $orders = (new LabOrderModel())
            ->where('client_id', (int) ($client['id'] ?? 0))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('client/panel/index', [
            'pageTitle' => 'Panel de Cliente - POT Prótesis Dental',
            'metaDescription' => 'Consulta de órdenes y estatus para clientes.',
            'orders' => $orders,
            'client' => $client,
        ]);
    }
}
