<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Blog extends BaseController
{
    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new BlogPostModel();

        if ($query !== '') {
            $model->groupStart()
                ->like('title', $query)
                ->orLike('content', $query)
                ->groupEnd();
        }

        $posts = $model->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->findAll();

        return view('admin/blog/index', [
            'pageTitle' => 'Blog - Admin POT',
            'metaDescription' => 'Gestión de entradas del blog.',
            'posts' => $posts,
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

        (new BlogPostModel())->insert($data);

        return redirect()->to('/admin/blog')->with('success', 'Entrada creada correctamente.');
    }

    public function edit(int $id): string
    {
        return $this->renderForm($this->findOrFail($id), true);
    }

    public function update(int $id)
    {
        $post = $this->findOrFail($id);
        $data = $this->requestData();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('error', 'Revise los datos capturados.');
        }

        $uploadError = $this->handleImageUpload($data, $post);

        if ($uploadError !== null) {
            return redirect()->back()->withInput()->with('error', $uploadError);
        }

        $data['slug'] = $this->buildUniqueSlug($data['title'], (int) $post['id']);

        (new BlogPostModel())->update($id, $data);

        return redirect()->to('/admin/blog')->with('success', 'Entrada actualizada correctamente.');
    }

    public function delete(int $id)
    {
        $post = $this->findOrFail($id);

        if (! empty($post['image_path'])) {
            $this->deleteLocalImage((string) $post['image_path']);
        }

        (new BlogPostModel())->delete($id);

        return redirect()->to('/admin/blog')->with('success', 'Entrada eliminada correctamente.');
    }

    private function renderForm(?array $post, bool $isEdit): string
    {
        return view('admin/blog/form', [
            'pageTitle' => ($isEdit ? 'Editar' : 'Nueva') . ' Entrada - Admin POT',
            'metaDescription' => 'Formulario del blog.',
            'post' => $post,
            'isEdit' => $isEdit,
            'currentImageUrl' => $this->imageUrl($post['image_path'] ?? null),
        ]);
    }

    private function requestData(): array
    {
        return [
            'title' => trim((string) $this->request->getPost('title')),
            'content' => trim((string) $this->request->getPost('content')),
            'image_path' => trim((string) $this->request->getPost('image_path')) ?: null,
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];
    }

    private function rules(): array
    {
        return [
            'title' => 'required|min_length[3]|max_length[180]',
            'content' => 'required|min_length[20]',
            'image_path' => 'permit_empty|max_length[255]',
        ];
    }

    private function findOrFail(int $id): array
    {
        $post = (new BlogPostModel())->find($id);

        if (! is_array($post)) {
            throw PageNotFoundException::forPageNotFound('Entrada no encontrada.');
        }

        return $post;
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
            $this->deleteLocalImage((string) $current['image_path']);
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
        $slug = $baseSlug !== '' ? $baseSlug : 'entrada';
        $model = new BlogPostModel();
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
