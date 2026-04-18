<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryItemModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Gallery extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new GalleryItemModel();

        if ($query !== '') {
            $model->groupStart()
                ->like('title', $query)
                ->orLike('alt_text', $query)
                ->groupEnd();
        }

        $items = $model->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();

        return view('admin/gallery/index', [
            'pageTitle' => 'Galería - Admin POT',
            'metaDescription' => 'Gestión de galería del sitio.',
            'items' => $items,
            'searchQuery' => $query,
        ]);
    }

    public function create(): string
    {
        return $this->renderForm(null, false);
    }

    public function store()
    {
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new GalleryItemModel())->insert($data);

        return redirect()->to('/admin/galeria')->with('success', 'Elemento de galería creado correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOrFail($id), true);
    }

    public function update(int $id)
    {
        $this->findOrFail($id);
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        (new GalleryItemModel())->update($id, $data);

        return redirect()->to('/admin/galeria')->with('success', 'Elemento de galería actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        (new GalleryItemModel())->delete($id);

        return redirect()->to('/admin/galeria')->with('success', 'Elemento de galería eliminado correctamente.');
    }

    private function renderForm(?array $item, bool $isEdit): string
    {
        return view('admin/gallery/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nuevo') . ' Elemento de Galería - Admin POT',
            'metaDescription' => 'Formulario de galería.',
            'item' => $item,
            'isEdit' => $isEdit,
        ]);
    }

    private function requestData(): array
    {
        return [
            'title' => trim((string) $this->request->getPost('title')),
            'image_path' => trim((string) $this->request->getPost('image_path')),
            'alt_text' => trim((string) $this->request->getPost('alt_text')) ?: null,
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];
    }

    private function rules(): array
    {
        return [
            'title' => 'required|min_length[3]|max_length[160]',
            'image_path' => 'required|max_length[255]',
            'alt_text' => 'permit_empty|max_length[180]',
            'sort_order' => 'permit_empty|integer',
        ];
    }

    private function findOrFail(int $id): array
    {
        $item = (new GalleryItemModel())->find($id);

        if (! is_array($item)) {
            throw PageNotFoundException::forPageNotFound('Elemento de galería no encontrado.');
        }

        return $item;
    }
}
