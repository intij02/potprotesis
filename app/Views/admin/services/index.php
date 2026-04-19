<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1>Servicios</h1>
                <p>Administre los servicios publicados en la web.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/servicios/nuevo') ?>" class="btn btn-primary btn-small">Nuevo servicio</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar servicio">
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
                            <th>Título</th>
                            <th>Imagen</th>
                            <th>Orden</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($services === []): ?>
                            <tr><td colspan="5">No hay servicios registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><strong><?= esc($service['title']) ?></strong><br><span class="muted-text"><?= esc($service['summary']) ?></span></td>
                                    <td>
                                        <?php if (! empty($service['image_path'])): ?>
                                            <img src="<?= esc(preg_match('#^https?://#i', $service['image_path']) ? $service['image_path'] : base_url($service['image_path'])) ?>" alt="<?= esc($service['title']) ?>" class="admin-thumb">
                                        <?php else: ?>
                                            <span class="muted-text">Sin imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc((string) $service['sort_order']) ?></td>
                                    <td><?= (bool) $service['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/servicios/editar/' . $service['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar servicio" title="Editar servicio"><i class="fa-solid fa-pen"></i></a>
                                            <form method="post" action="<?= base_url('admin/servicios/eliminar/' . $service['id']) ?>" onsubmit="return confirm('¿Desea eliminar este servicio?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small btn-danger-soft admin-action-icon" aria-label="Eliminar servicio" title="Eliminar servicio"><i class="fa-solid fa-trash"></i></button>
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
