<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1><?= $isEdit ? 'Editar servicio' : 'Nuevo servicio' ?></h1>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/servicios') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" enctype="multipart/form-data" class="stack-form" action="<?= $isEdit ? base_url('admin/servicios/actualizar/' . $service['id']) : base_url('admin/servicios/guardar') ?>">
                <?= csrf_field() ?>
                <div class="row g-4 align-items-start">
                    <div class="col-12 col-lg-4">
                        <div class="admin-image-panel">
                            <h3>Imagen activa</h3>
                            <?php if ($currentImageUrl !== null): ?>
                                <img id="serviceImagePreview" src="<?= esc($currentImageUrl) ?>" alt="<?= esc(old('title', $service['title'] ?? 'Servicio')) ?>" class="admin-image-preview">
                                <div id="serviceImagePlaceholder" class="admin-image-placeholder d-none">Sin imagen cargada</div>
                            <?php else: ?>
                                <img id="serviceImagePreview" src="" alt="Vista previa de servicio" class="admin-image-preview d-none">
                                <div id="serviceImagePlaceholder" class="admin-image-placeholder">Sin imagen cargada</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div>
                            <label for="title" class="form-label">Título</label>
                            <input id="title" name="title" class="form-control" type="text" value="<?= esc(old('title', $service['title'] ?? '')) ?>" required>
                        </div>
                        <div>
                            <label for="summary" class="form-label">Descripción</label>
                            <textarea id="summary" name="summary" class="form-control" rows="6" required><?= esc(old('summary', $service['summary'] ?? '')) ?></textarea>
                        </div>
                        <div>
                            <label for="image_file" class="form-label">Cambiar imagen</label>
                            <input id="image_file" name="image_file" class="form-control" type="file" accept=".jpg,.jpeg,.png,.webp,.gif">
                            <p class="muted-text">Si selecciona un archivo, reemplaza la imagen actual.</p>
                        </div>
                        <div>
                            <label for="sort_order" class="form-label">Orden</label>
                            <input id="sort_order" name="sort_order" class="form-control" type="number" value="<?= esc(old('sort_order', (string) ($service['sort_order'] ?? 0))) ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active', isset($service) ? ((bool) $service['is_active'] ? '1' : '') : '1') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Servicio activo</label>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear servicio' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image_file');
    const preview = document.getElementById('serviceImagePreview');
    const placeholder = document.getElementById('serviceImagePlaceholder');

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
