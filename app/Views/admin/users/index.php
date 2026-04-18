<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="eyebrow">Panel Admin</span>
                <h1>Usuarios</h1>
                <p>Solo los administradores pueden dar de alta, editar y eliminar usuarios.</p>
            </div>
            <a href="<?= base_url('admin/usuarios/nuevo') ?>" class="btn btn-primary">Nuevo usuario</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search">
                <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar por usuario, nombre o rol">
                <button type="submit" class="btn btn-primary btn-small">Buscar</button>
            </form>
        </div>

        <div class="table-card">
            <table class="admin-table">
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
</section>
<?= $this->endSection() ?>
