<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow">CMS</span>
                <h1>Mensajes de contacto</h1>
                <p>Mensajes enviados desde el formulario público.</p>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>

        <div class="table-card">
            <div class="table-responsive">
                <table class="admin-table table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Mensaje</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($messages === []): ?>
                            <tr><td colspan="5">No hay mensajes registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= esc($message['created_at']) ?></td>
                                    <td><?= esc($message['name']) ?></td>
                                    <td><?= esc($message['email']) ?><br><span class="muted-text"><?= esc($message['phone'] ?? '') ?></span></td>
                                    <td><?= esc($message['message']) ?></td>
                                    <td>
                                        <?php if ((bool) $message['is_read']): ?>
                                            <span class="muted-text">Leído</span>
                                        <?php else: ?>
                                            <form method="post" action="<?= base_url('admin/mensajes-contacto/marcar-leido/' . $message['id']) ?>">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline btn-small">Marcar leído</button>
                                            </form>
                                        <?php endif; ?>
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
