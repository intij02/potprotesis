<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow" style="background: aquamarine;">Panel - Ordenes</span>
                <h1>Administración de órdenes</h1>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="admin-toolbar">
            <form method="get" class="admin-search row g-2 align-items-center">
                <div class="col">
                    <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar por dentista, paciente, orden o teléfono">
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
                        <th>Orden</th>
                        <th>Dentista</th>
                        <th>Paciente</th>
                        <th>Entrega</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6">No hay órdenes registradas todavía.</td>
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
                                <td>
                                    <?php if (admin_can_edit_orders()): ?>
                                        <a href="<?= base_url('admin/ordenes/editar/' . $order['id']) ?>" class="btn btn-outline btn-small">Editar</a>
                                    <?php else: ?>
                                        <span class="muted-text">Solo lectura</span>
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
