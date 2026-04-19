<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Panel Admin</span>
                <h1>Usuarios</h1>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/usuarios/nuevo') ?>" class="btn btn-primary btn-small">Nuevo usuario</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar por usuario, nombre o rol">
                </div>
                <div class="col-12 col-sm-auto">
                    <button type="submit" class="btn btn-primary btn-small w-100">Buscar</button>
                </div>
            </form>
        </div>

        <div class="table-card">
            <div class="table-responsive">
            <table class="admin-table table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users === []): ?>
                        <tr>
                            <td colspan="6">No hay usuarios registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <?php if ((int) ($user['id'] ?? 0) === 1) {
                                continue;
                            } ?>
                            <tr>
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['full_name']) ?></td>
                                <td><?= esc($roleLabels[$user['role']] ?? $user['role']) ?></td>
                                <td><?= (bool) $user['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                <td><?= esc($user['created_at'] ?? '') ?></td>
                                <td>
                                    <div class="admin-actions">
                                        <a href="<?= base_url('admin/usuarios/editar/' . $user['id']) ?>" class="btn btn-outline btn-small">Editar</a>
                                        <form method="post" action="<?= base_url('admin/usuarios/eliminar/' . $user['id']) ?>" onsubmit="return confirm('¿Desea eliminar este usuario?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline btn-small btn-danger-soft">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
