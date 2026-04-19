<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1>Galería</h1>
                <p>Administre las imágenes y títulos de la galería pública.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/galeria/nuevo') ?>" class="btn btn-primary btn-small">Nuevo elemento</a>
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
                                    <td>
                                        <?php if (! empty($item['image_path'])): ?>
                                            <img src="<?= esc(preg_match('#^https?://#i', $item['image_path']) ? $item['image_path'] : base_url($item['image_path'])) ?>" alt="<?= esc($item['alt_text'] ?: $item['title']) ?>" class="admin-thumb">
                                        <?php else: ?>
                                            <span class="muted-text">Sin imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['alt_text'] ?? '') ?></td>
                                    <td><?= esc((string) $item['sort_order']) ?></td>
                                    <td><?= (bool) $item['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/galeria/editar/' . $item['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar elemento" title="Editar elemento"><i class="fa-solid fa-pen"></i></a>
                                            <form method="post" action="<?= base_url('admin/galeria/eliminar/' . $item['id']) ?>" onsubmit="return confirm('¿Desea eliminar este elemento?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small btn-danger-soft admin-action-icon" aria-label="Eliminar elemento" title="Eliminar elemento"><i class="fa-solid fa-trash"></i></button>
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
