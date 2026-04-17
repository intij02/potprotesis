<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LabOrderModel;

class Orders extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $labOrderModel = new LabOrderModel();

        if ($query !== '') {
            $labOrderModel
                ->groupStart()
                ->like('order_number', $query)
                ->orLike('dentist_name', $query)
                ->orLike('patient_name', $query)
                ->orLike('contact_phone', $query)
                ->groupEnd();
        }

        $orders = $labOrderModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/orders/index', [
            'pageTitle' => 'Admin de Órdenes - POT Prótesis Dental',
            'metaDescription' => 'Panel administrativo para consultar, crear, editar y eliminar órdenes.',
            'orders' => $orders,
            'searchQuery' => $query,
        ]);
    }
}
