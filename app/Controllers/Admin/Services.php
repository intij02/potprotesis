<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;
use CodeIgniter\Files\File;
use CodeIgniter\Exceptions\PageNotFoundException;

class Services extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new ServiceModel();

        if ($query !== '') {
            $model->groupStart()
                ->like('title', $query)
                ->orLike('summary', $query)
                ->groupEnd();
        }

        $services = $model->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();

        return view('admin/services/index', [
            'pageTitle' => 'Servicios - Admin POT',
            'metaDescription' => 'Gestión de servicios del sitio.',
            'services' => $services,
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

        $data['slug'] = $this->buildUniqueSlug($data['title']);

        (new ServiceModel())->insert($data);

        return redirect()->to('/admin/servicios')->with('success', 'Servicio creado correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOrFail($id), true);
    }

    public function update(int $id)
    {
        $service = $this->findOrFail($id);
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $uploadError = $this->handleImageUpload($data, $service);

        if ($uploadError !== null) {
            return redirect()->back()->withInput()->with('error', $uploadError);
        }

        $data['slug'] = $this->buildUniqueSlug($data['title'], (int) $service['id']);

        (new ServiceModel())->update($id, $data);

        return redirect()->to('/admin/servicios')->with('success', 'Servicio actualizado correctamente.');
    }

    public function delete(int $id)
    {
        $this->findOrFail($id);
        (new ServiceModel())->delete($id);

        return redirect()->to('/admin/servicios')->with('success', 'Servicio eliminado correctamente.');
    }

    private function renderForm(?array $service, bool $isEdit): string
    {
        return view('admin/services/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nuevo') . ' Servicio - Admin POT',
            'metaDescription' => 'Formulario de servicios.',
            'service' => $service,
            'isEdit' => $isEdit,
            'currentImageUrl' => $this->imageUrl($service['image_path'] ?? null),
        ]);
    }

    private function requestData(): array
    {
        return [
            'title' => trim((string) $this->request->getPost('title')),
            'summary' => trim((string) $this->request->getPost('summary')),
            'image_path' => trim((string) $this->request->getPost('image_path')) ?: null,
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];
    }

    private function rules(): array
    {
        return [
            'title' => 'required|min_length[3]|max_length[160]',
            'summary' => 'required|min_length[10]|max_length[2000]',
            'image_path' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
        ];
    }

    private function findOrFail(int $id): array
    {
        $service = (new ServiceModel())->find($id);

        if (! is_array($service)) {
            throw PageNotFoundException::forPageNotFound('Servicio no encontrado.');
        }

        return $service;
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

    private function buildUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = url_title($title, '-', true);
        $slug = $baseSlug !== '' ? $baseSlug : 'servicio';
        $model = new ServiceModel();
        $suffix = 1;

        while (true) {
            $query = $model->where('slug', $slug);

            if ($excludeId !== null) {
                $query->where('id !=', $excludeId);
            }

            if ($query->first() === null) {
                return $slug;
            }

            $suffix++;
            $slug = $baseSlug . '-' . $suffix;
        }
    }
}
