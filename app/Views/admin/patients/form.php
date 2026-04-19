<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container narrow">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Catálogos</span>
                <h1><?= $isEdit ? 'Editar paciente' : 'Nuevo paciente' ?></h1>
                <p>Asigne cada paciente al cliente correcto para usarlo en la orden.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/pacientes') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= $isEdit ? base_url('admin/pacientes/actualizar/' . $patient['id']) : base_url('admin/pacientes/guardar') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="client_id" class="form-label">Cliente</label>
                    <select id="client_id" name="client_id" class="form-select" required>
                        <option value="">Seleccione un cliente</option>
                        <?php $selectedClientId = old('client_id', $patient['client_id'] ?? ''); ?>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= esc((string) $client['id']) ?>" <?= (string) $selectedClientId === (string) $client['id'] ? 'selected' : '' ?>>
                                <?= esc($client['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

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

                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear paciente' ?></button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
