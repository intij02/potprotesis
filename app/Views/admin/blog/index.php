<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">CMS</span>
                <h1>Blog</h1>
                <p>Administre las entradas publicadas en el blog.</p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/blog/nuevo') ?>" class="btn btn-primary btn-small">Nueva entrada</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar entrada">
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
                            <th>Portada</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($posts === []): ?>
                            <tr><td colspan="5">No hay entradas registradas.</td></tr>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><strong><?= esc($post['title']) ?></strong><br><span class="muted-text"><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content']))), 0, 140)) ?><?= mb_strlen(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content'])))) > 140 ? '…' : '' ?></span></td>
                                    <td>
                                        <?php if (! empty($post['image_path'])): ?>
                                            <img src="<?= esc(preg_match('#^https?://#i', $post['image_path']) ? $post['image_path'] : base_url($post['image_path'])) ?>" alt="<?= esc($post['title']) ?>" class="admin-thumb">
                                        <?php else: ?>
                                            <span class="muted-text">Sin imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc(site_datetime($post['created_at'] ?? null, 'd/m/Y')) ?></td>
                                    <td><?= (bool) $post['is_active'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <div class="admin-actions">
                                            <a href="<?= base_url('admin/blog/editar/' . $post['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar entrada" title="Editar entrada"><i class="fa-solid fa-pen"></i></a>
                                            <form method="post" action="<?= base_url('admin/blog/eliminar/' . $post['id']) ?>" onsubmit="return confirm('¿Desea eliminar esta entrada?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small btn-danger-soft admin-action-icon" aria-label="Eliminar entrada" title="Eliminar entrada"><i class="fa-solid fa-trash"></i></button>
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
