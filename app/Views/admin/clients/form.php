<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container narrow">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Catálogos</span>
                <h1><?= $isEdit ? 'Editar cliente' : 'Nuevo cliente' ?></h1>
                <p>Datos base para seleccionar el dentista desde la recepción de órdenes.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/clientes') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= $isEdit ? base_url('admin/clientes/actualizar/' . $client['id']) : base_url('admin/clientes/guardar') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" name="name" class="form-control" type="text" value="<?= esc(old('name', $client['name'] ?? '')) ?>" required>
                </div>

                <div>
                    <label for="contact_phone" class="form-label">Teléfono</label>
                    <input id="contact_phone" name="contact_phone" class="form-control" type="text" value="<?= esc(old('contact_phone', $client['contact_phone'] ?? '')) ?>">
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" class="form-control" type="email" value="<?= esc(old('email', $client['email'] ?? '')) ?>" required>
                </div>

                <div>
                    <label for="password" class="form-label"><?= $isEdit ? 'Nueva contraseña' : 'Contraseña' ?></label>
                    <input id="password" name="password" class="form-control" type="password" <?= $isEdit ? '' : 'required' ?>>
                    <p class="muted-text"><?= $isEdit ? 'Déjela vacía si no desea cambiarla.' : 'Mínimo 6 caracteres para el acceso del cliente.' ?></p>
                </div>

                <div>
                    <label for="notes" class="form-label">Notas</label>
                    <textarea id="notes" name="notes" class="form-control" rows="5"><?= esc(old('notes', $client['notes'] ?? '')) ?></textarea>
                </div>

                <div class="mb-3 form-check">
                    <?php $isActive = old('is_active', isset($client) ? ((bool) $client['is_active'] ? '1' : '') : '1'); ?>
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= $isActive === '1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Cliente activo</label>
                </div>

                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear cliente' ?></button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
