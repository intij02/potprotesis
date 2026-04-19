<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container narrow">
        <span class="eyebrow">Mis Pacientes</span>
        <h1><?= esc($client['name'] ?? 'Cliente') ?></h1>
        <p>Da de alta y mantén actualizados los pacientes vinculados a tu cuenta.</p>
        <div class="hero-actions">
            <a href="<?= base_url('cliente/pacientes/nuevo') ?>" class="btn btn-primary btn-small">Nuevo paciente</a>
            <a href="<?= base_url('cliente/panel') ?>" class="btn btn-outline btn-small">Volver al panel</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search">
                <input type="search" name="q" value="<?= esc($searchQuery) ?>" placeholder="Buscar paciente">
                <button type="submit" class="btn btn-outline btn-small">Buscar</button>
            </form>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="admin-table table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Notas</th>
                            <th>Estatus</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($patients === []): ?>
                            <tr><td colspan="5">Todavía no tienes pacientes registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($patients as $patient): ?>
                                <tr>
                                    <td><?= esc($patient['name']) ?></td>
                                    <td><?= esc($patient['notes'] ?: 'Sin notas') ?></td>
                                    <td>
                                        <span class="status-pill <?= ! empty($patient['is_active']) ? 'status-lista' : 'status-cancelada' ?>">
                                            <?= ! empty($patient['is_active']) ? 'Activo' : 'Inactivo' ?>
                                        </span>
                                    </td>
                                    <td><?= esc(site_datetime($patient['created_at'] ?? null)) ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('cliente/pacientes/editar/' . $patient['id']) ?>" class="btn btn-outline btn-small">Editar</a>
                                            <form method="post" action="<?= base_url('cliente/pacientes/eliminar/' . $patient['id']) ?>" onsubmit="return confirm('¿Eliminar este paciente?');">
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
