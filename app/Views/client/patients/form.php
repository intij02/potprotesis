<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container narrow">
        <span class="eyebrow">Mis Pacientes</span>
        <h1><?= $isEdit ? 'Editar paciente' : 'Nuevo paciente' ?></h1>
        <p>Registra los pacientes asociados a tu cuenta para mantener tu catálogo actualizado.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= $isEdit ? base_url('cliente/pacientes/actualizar/' . $patient['id']) : base_url('cliente/pacientes/guardar') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="name" class="form-label">Nombre del paciente</label>
                    <input id="name" name="name" class="form-control" type="text" value="<?= esc(old('name', $patient['name'] ?? '')) ?>" required>
                </div>

                <div>
                    <label for="notes" class="form-label">Notas</label>
                    <textarea id="notes" name="notes" class="form-control" rows="5"><?= esc(old('notes', $patient['notes'] ?? '')) ?></textarea>
                </div>

                <div class="mb-3 form-check">
                    <?php $isActive = old('is_active', isset($patient) ? ((bool) $patient['is_active'] ? '1' : '') : '1'); ?>
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= $isActive === '1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Paciente activo</label>
                </div>

                <div class="hero-actions">
                    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear paciente' ?></button>
                    <a href="<?= base_url('cliente/pacientes') ?>" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
