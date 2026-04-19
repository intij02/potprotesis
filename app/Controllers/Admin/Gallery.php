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

        $uploadError = $this->handleImageUpload($data);

        if ($uploadError !== null) {
            return redirect()->back()->withInput()->with('error', $uploadError);
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
        $item = $this->findOrFail($id);
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $uploadError = $this->handleImageUpload($data, $item);

        if ($uploadError !== null) {
            return redirect()->back()->withInput()->with('error', $uploadError);
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
            'currentImageUrl' => $this->imageUrl($item['image_path'] ?? null),
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

    private function handleImageUpload(array &$data, ?array $current = null): ?string
    {
        $file = $this->request->getFile('image_file');

        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            return 'No fue posible cargar la imagen.';
        }

        if (! in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            return 'La imagen debe ser JPG, PNG, WEBP o GIF.';
        }

        if ($file->getSizeByUnit('mb') > 5) {
            return 'La imagen no debe superar 5 MB.';
        }

        $targetPath = FCPATH . 'uploads/cms';

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($targetPath, $newName, true);
        $data['image_path'] = 'uploads/cms/' . $newName;

        if ($current !== null && ! empty($current['image_path'])) {
            $this->deleteLocalImage($current['image_path']);
        }

        return null;
    }

    private function deleteLocalImage(string $path): void
    {
        if (preg_match('#^uploads/cms/#', $path) !== 1) {
            return;
        }

        $absolute = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }

    private function imageUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return base_url($path);
    }
}
