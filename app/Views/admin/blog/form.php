<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1><?= $isEdit ? 'Editar entrada' : 'Nueva entrada' ?></h1>
                <p>Defina portada, título y contenido del blog.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" enctype="multipart/form-data" class="stack-form" action="<?= $isEdit ? base_url('admin/blog/actualizar/' . $post['id']) : base_url('admin/blog/guardar') ?>">
                <?= csrf_field() ?>
                <div class="row g-4 align-items-start">
                    <div class="col-md">
                        <div>
                            <label for="title" class="form-label">Título</label>
                            <input id="title" name="title" class="form-control" type="text" value="<?= esc(old('title', $post['title'] ?? '')) ?>" required>
                        </div>
                        <div>
                            <label for="image_file" class="form-label">Seleccionar portada</label>
                            <input id="image_file" name="image_file" class="form-control" type="file" accept=".jpg,.jpeg,.png,.webp,.gif">
                        </div>
                        <div>
                            <label for="content" class="form-label">Contenido Blog</label>
                            <textarea id="content" name="content" class="form-control" rows="18" required><?= old('content', $post['content'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active', isset($post) ? ((bool) $post['is_active'] ? '1' : '') : '1') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Entrada activa</label>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear entrada' ?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="admin-image-panel">
                            <h3>Imagen de portada</h3>
                            <?php if ($currentImageUrl !== null): ?>
                                <img id="blogImagePreview" src="<?= esc($currentImageUrl) ?>" alt="<?= esc(old('title', $post['title'] ?? 'Entrada')) ?>" class="admin-image-preview">
                                <div id="blogImagePlaceholder" class="admin-image-placeholder d-none">Sin imagen cargada</div>
                            <?php else: ?>
                                <img id="blogImagePreview" src="" alt="Vista previa de portada" class="admin-image-preview d-none">
                                <div id="blogImagePlaceholder" class="admin-image-placeholder">Sin imagen cargada</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="https://cdn.tiny.cloud/1/lsdl48wuvync9vv6m3xgq9b0zcz6vdohq0gw6rxptdbzdkx7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image_file');
    const preview = document.getElementById('blogImagePreview');
    const placeholder = document.getElementById('blogImagePlaceholder');

    if (input && preview && placeholder) {
        input.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];

            if (!file) {
                if (preview.getAttribute('src')) {
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                } else {
                    preview.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                }
                return;
            }

            const reader = new FileReader();
            reader.onload = function (loadEvent) {
                preview.src = loadEvent.target?.result || '';
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });
    }

    if (window.tinymce) {
        tinymce.init({
            selector: '#content',
            menubar: true,
            branding: false,
            height: 520,
            plugins: 'lists link table code wordcount preview',
            toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link table | removeformat code preview',
            content_style: 'body { font-family: Inter, Arial, sans-serif; font-size: 16px; line-height: 1.6; }'
        });
    }
});
</script>
<?= $this->endSection() ?>
