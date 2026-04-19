<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container narrow">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Panel Admin</span>
                <h1><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h1>
                <p>Gestione credenciales y permisos del personal con acceso al panel.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= $isEdit ? base_url('admin/usuarios/actualizar/' . $user['id']) : base_url('admin/usuarios/guardar') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="username" class="form-label">Usuario</label>
                    <input id="username" name="username" class="form-control" type="text" value="<?= esc(old('username', $user['username'] ?? '')) ?>" required>
                </div>

                <div>
                    <label for="full_name" class="form-label">Nombre completo</label>
                    <input id="full_name" name="full_name" class="form-control" type="text" value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>" required>
                </div>

                <div>
                    <label for="password" class="form-label"><?= $isEdit ? 'Nueva contraseña' : 'Contraseña' ?></label>
                    <input id="password" name="password" class="form-control" type="password" <?= $isEdit ? '' : 'required' ?>>
                    <p class="muted-text"><?= $isEdit ? 'Déjela vacía si no desea cambiarla.' : 'Mínimo 6 caracteres.' ?></p>
                </div>

                <div>
                    <label for="role" class="form-label">Rol</label>
                    <select id="role" name="role" class="form-select" required>
                        <?php $selectedRole = old('role', $user['role'] ?? 'staff'); ?>
                        <?php foreach ($roleOptions as $roleValue => $roleLabel): ?>
                            <option value="<?= esc($roleValue) ?>" <?= $selectedRole === $roleValue ? 'selected' : '' ?>>
                                <?= esc($roleLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <label class="inline-check form-check col-2">
                    <?php $isActive = old('is_active', isset($user) ? ((bool) $user['is_active'] ? '1' : '') : '1'); ?>
                    <input type="checkbox" class="form-check-input" name="is_active" value="1" <?= $isActive === '1' ? 'checked' : '' ?>>
                    <span>Usuario activo</span>
                </label>

                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear usuario' ?></button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
