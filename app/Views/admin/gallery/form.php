<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1><?= $isEdit ? 'Editar elemento de galería' : 'Nuevo elemento de galería' ?></h1>
                <p>Defina imagen, título y texto alternativo para el sitio.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/galeria') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" enctype="multipart/form-data" class="stack-form" action="<?= $isEdit ? base_url('admin/galeria/actualizar/' . $item['id']) : base_url('admin/galeria/guardar') ?>">
                <?= csrf_field() ?>
                <div class="row g-4 align-items-start">
                    <div class="col-12 col-lg-4">
                        <div class="admin-image-panel">
                            <h3>Imagen activa</h3>
                            <?php if ($currentImageUrl !== null): ?>
                                <img id="galleryImagePreview" src="<?= esc($currentImageUrl) ?>" alt="<?= esc(old('alt_text', $item['alt_text'] ?? $item['title'] ?? 'Imagen')) ?>" class="admin-image-preview">
                                <div id="galleryImagePlaceholder" class="admin-image-placeholder d-none">Sin imagen cargada</div>
                            <?php else: ?>
                                <img id="galleryImagePreview" src="" alt="Vista previa de galería" class="admin-image-preview d-none">
                                <div id="galleryImagePlaceholder" class="admin-image-placeholder">Sin imagen cargada</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div>
                            <label for="title" class="form-label">Título</label>
                            <input id="title" name="title" class="form-control" type="text" value="<?= esc(old('title', $item['title'] ?? '')) ?>" required>
                        </div>
                        <div>
                            <label for="image_file" class="form-label">Cambiar imagen</label>
                            <input id="image_file" name="image_file" class="form-control" type="file" accept=".jpg,.jpeg,.png,.webp,.gif">
                            <p class="muted-text">Si selecciona un archivo, reemplaza la imagen actual.</p>
                        </div>
                        <div>
                            <label for="alt_text" class="form-label">Texto alternativo</label>
                            <input id="alt_text" name="alt_text" class="form-control" type="text" value="<?= esc(old('alt_text', $item['alt_text'] ?? '')) ?>">
                        </div>
                        <div>
                            <label for="sort_order" class="form-label">Orden</label>
                            <input id="sort_order" name="sort_order" class="form-control" type="number" value="<?= esc(old('sort_order', (string) ($item['sort_order'] ?? 0))) ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active', isset($item) ? ((bool) $item['is_active'] ? '1' : '') : '1') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Elemento activo</label>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear elemento' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image_file');
    const preview = document.getElementById('galleryImagePreview');
    const placeholder = document.getElementById('galleryImagePlaceholder');

    if (!input || !preview || !placeholder) {
        return;
    }

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
});
</script>
<?= $this->endSection() ?>
