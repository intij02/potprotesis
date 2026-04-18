<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiteSettingModel;

class Settings extends BaseController
{
    private array $keys = [
        'contact_phone',
        'contact_phone_href',
        'contact_whatsapp',
        'contact_whatsapp_href',
        'contact_email',
        'contact_address',
        'contact_hours',
        'contact_map_embed_url',
        'contact_form_recipient_email',
    ];

    public function edit(): string
    {
        return view('admin/settings/form', [
            'pageTitle' => 'Configuración del Sitio - Admin POT',
            'metaDescription' => 'Configuración de contacto y destinatarios.',
            'settings' => $this->currentValues(),
        ]);
    }

    public function update()
    {
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $model = new SiteSettingModel();

        foreach ($data as $key => $value) {
            $row = $model->where('setting_key', $key)->first();

            if (is_array($row)) {
                $model->update($row['id'], ['setting_value' => $value]);
            } else {
                $model->insert([
                    'setting_key' => $key,
                    'setting_value' => $value,
                ]);
            }
        }

        return redirect()->to('/admin/configuracion')->with('success', 'Configuración actualizada correctamente.');
    }

    private function currentValues(): array
    {
        $values = [];

        foreach ($this->keys as $key) {
            $values[$key] = old($key, site_setting($key, ''));
        }

        return $values;
    }

    private function requestData(): array
    {
        $data = [];

        foreach ($this->keys as $key) {
            $data[$key] = trim((string) $this->request->getPost($key));
        }

        return $data;
    }

    private function rules(): array
    {
        return [
            'contact_phone' => 'required|max_length[80]',
            'contact_phone_href' => 'required|max_length[30]',
            'contact_whatsapp' => 'required|max_length[80]',
            'contact_whatsapp_href' => 'required|max_length[30]',
            'contact_email' => 'required|valid_email|max_length[190]',
            'contact_address' => 'required|max_length[255]',
            'contact_hours' => 'required|max_length[190]',
            'contact_map_embed_url' => 'required|valid_url_strict|max_length[2000]',
            'contact_form_recipient_email' => 'required|valid_email|max_length[190]',
        ];
    }
}
