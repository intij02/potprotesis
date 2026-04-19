<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container narrow">
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
            <form method="post" class="stack-form" action="<?= $isEdit ? base_url('admin/galeria/actualizar/' . $item['id']) : base_url('admin/galeria/guardar') ?>">
                <?= csrf_field() ?>
                <div>
                    <label for="title" class="form-label">Título</label>
                    <input id="title" name="title" class="form-control" type="text" value="<?= esc(old('title', $item['title'] ?? '')) ?>" required>
                </div>
                <div>
                    <label for="image_path" class="form-label">Ruta o URL de imagen</label>
                    <input id="image_path" name="image_path" class="form-control" type="text" value="<?= esc(old('image_path', $item['image_path'] ?? '')) ?>" required>
                </div>
                <div>
                    <label for="alt_text" class="form-label">Texto alternativo</label>
                    <input id="alt_text" name="alt_text" class="form-control" type="text" value="<?= esc(old('alt_text', $item['alt_text'] ?? '')) ?>">
                </div>
                <div>
                    <label for="sort_order" class="form-label">Orden</label>
                    <input id="sort_order" name="sort_order" class="form-control" type="number" value="<?= esc(old('sort_order', (string) ($item['sort_order'] ?? 0))) ?>">
                </div>
                <label class="inline-check form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" value="1" <?= old('is_active', isset($item) ? ((bool) $item['is_active'] ? '1' : '') : '1') === '1' ? 'checked' : '' ?>>
                    <span>Elemento activo</span>
                </label>
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear elemento' ?></button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
