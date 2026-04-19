<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Catálogos</span>
                <h1>Pacientes</h1>
                <p>Administre los pacientes disponibles para cada cliente.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/pacientes/nuevo') ?>" class="btn btn-primary btn-small">Nuevo paciente</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar paciente">
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
                            <th>Paciente</th>
                            <th>Cliente</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($patients === []): ?>
                            <tr><td colspan="4">No hay pacientes registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($patients as $patient): ?>
                                <tr>
                                    <td><strong><?= esc($patient['name']) ?></strong></td>
                                    <td><?= esc($clientNames[(int) $patient['client_id']] ?? '') ?></td>
                                    <td><?= (bool) $patient['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/pacientes/editar/' . $patient['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar paciente" title="Editar paciente"><i class="fa-solid fa-pen"></i></a>
                                            <form method="post" action="<?= base_url('admin/pacientes/eliminar/' . $patient['id']) ?>" onsubmit="return confirm('¿Desea eliminar este paciente?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small btn-danger-soft admin-action-icon" aria-label="Eliminar paciente" title="Eliminar paciente"><i class="fa-solid fa-trash"></i></button>
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
