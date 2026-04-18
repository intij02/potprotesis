<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ContactMessages extends BaseController
{
    public function index(): string
    {
        $messages = (new ContactMessageModel())
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/contact_messages/index', [
            'pageTitle' => 'Mensajes de Contacto - Admin POT',
            'metaDescription' => 'Consulta de mensajes recibidos desde el formulario.',
            'messages' => $messages,
        ]);
    }

    public function markRead(int $id)
    {
        $message = (new ContactMessageModel())->find($id);

        if (! is_array($message)) {
            throw PageNotFoundException::forPageNotFound('Mensaje no encontrado.');
        }

        (new ContactMessageModel())->update($id, ['is_read' => 1]);

        return redirect()->to('/admin/mensajes-contacto')->with('success', 'Mensaje marcado como leído.');
    }
}
