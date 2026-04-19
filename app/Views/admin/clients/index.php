<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Catálogos</span>
                <h1>Clientes</h1>
                <p>Administre dentistas y datos de contacto para las órdenes.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/clientes/nuevo') ?>" class="btn btn-primary btn-small">Nuevo cliente</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar cliente">
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
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acceso</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($clients === []): ?>
                            <tr><td colspan="6">No hay clientes registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><strong><?= esc($client['name']) ?></strong></td>
                                    <td><?= esc($client['contact_phone'] ?? '') ?></td>
                                    <td><?= esc($client['email'] ?? '') ?></td>
                                    <td><?= ! empty($client['password_hash']) ? 'Configurado' : 'Pendiente' ?></td>
                                    <td><?= (bool) $client['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/clientes/editar/' . $client['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar cliente" title="Editar cliente"><i class="fa-solid fa-pen"></i></a>
                                            <form method="post" action="<?= base_url('admin/clientes/eliminar/' . $client['id']) ?>" onsubmit="return confirm('¿Desea eliminar este cliente?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small btn-danger-soft admin-action-icon" aria-label="Eliminar cliente" title="Eliminar cliente"><i class="fa-solid fa-trash"></i></button>
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
