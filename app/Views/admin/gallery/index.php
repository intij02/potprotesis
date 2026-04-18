<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow">CMS</span>
                <h1>Galería</h1>
                <p>Administre las imágenes y títulos de la galería pública.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/galeria/nuevo') ?>" class="btn btn-primary">Nuevo elemento</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar elemento de galería">
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
                            <th>Alt</th>
                            <th>Orden</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($items === []): ?>
                            <tr><td colspan="6">No hay elementos de galería registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= esc($item['title']) ?></td>
                                    <td><?= esc($item['image_path']) ?></td>
                                    <td><?= esc($item['alt_text'] ?? '') ?></td>
                                    <td><?= esc((string) $item['sort_order']) ?></td>
                                    <td><?= (bool) $item['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/galeria/editar/' . $item['id']) ?>" class="btn btn-outline btn-small">Editar</a>
                                            <form method="post" action="<?= base_url('admin/galeria/eliminar/' . $item['id']) ?>" onsubmit="return confirm('¿Desea eliminar este elemento?');">
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
