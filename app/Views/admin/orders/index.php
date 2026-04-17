<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="eyebrow">Panel Admin</span>
                <h1>Administración de órdenes</h1>
                <p>Panel administrativo con sesión protegida y lectura inicial de órdenes.</p>
            </div>
            <a href="<?= base_url('admin/logout') ?>" class="btn btn-outline">Cerrar sesión</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search">
                <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar por dentista, paciente, orden o teléfono">
                <button type="submit" class="btn btn-primary btn-small">Buscar</button>
            </form>
        </div>

        <div class="table-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Dentista</th>
                        <th>Paciente</th>
                        <th>Entrega</th>
                        <th>Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="5">No hay órdenes registradas todavía.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= esc($order['order_number'] ?: '#' . $order['id']) ?></td>
                                <td><?= esc($order['dentist_name']) ?></td>
                                <td>
                                    <strong><?= esc($order['patient_name']) ?></strong><br>
                                    <span class="muted-text"><?= esc($order['contact_phone']) ?></span>
                                </td>
                                <td><?= esc($order['required_date']) ?></td>
                                <td><?= esc($order['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
