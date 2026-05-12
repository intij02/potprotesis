<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$totalOrders = count($orders);
$receivedCount = 0;
$inProgressCount = 0;
$readyCount = 0;
$deliveredCount = 0;
$cancelledCount = 0;

foreach ($orders as $order) {
    $status = (string) ($order['status'] ?? 'recibida');

    if ($status === 'recibida') {
        $receivedCount++;
    } elseif ($status === 'en_proceso') {
        $inProgressCount++;
    } elseif ($status === 'lista') {
        $readyCount++;
    } elseif ($status === 'entregada') {
        $deliveredCount++;
    } elseif ($status === 'cancelada') {
        $cancelledCount++;
    }
}
?>
<section class="section admin-dashboard-section">
    <div class="admin-dashboard-hero">
        <div>
            <span class="eyebrow eyebrow-aqua">Dashboard</span>
            <h2>Administración de órdenes</h2>
            <p>Consulta cargas activas, monitorea avances y entra rápido a los casos capturados.</p>
        </div>
        <div class="admin-dashboard-hero-actions">
            <span class="admin-dashboard-chip">Total: <?= esc((string) $totalOrders) ?></span>
            <span class="admin-dashboard-chip admin-dashboard-chip-accent">En proceso: <?= esc((string) $inProgressCount) ?></span>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="admin-dashboard-grid">
        <article class="admin-stat-card admin-stat-card-accent">
            <span>Órdenes recibidas</span>
            <strong><?= esc((string) $receivedCount) ?></strong>
            <small>Nuevos casos registrados y pendientes de toma.</small>
        </article>
        <article class="admin-stat-card">
            <span>En proceso</span>
            <strong><?= esc((string) $inProgressCount) ?></strong>
            <small>Trabajos activos dentro de producción.</small>
        </article>
        <article class="admin-stat-card">
            <span>Listas para entrega</span>
            <strong><?= esc((string) $readyCount) ?></strong>
            <small>Casos concluidos esperando salida.</small>
        </article>
        <article class="admin-stat-card">
            <span>Entregadas</span>
            <strong><?= esc((string) $deliveredCount) ?></strong>
            <small>Órdenes cerradas correctamente.</small>
        </article>
    </div>

    <div class="admin-dashboard-panels">
        <div class="table-card admin-dashboard-panel">
            <div class="admin-toolbar admin-toolbar-spread">
                <div>
                    <h3>Órdenes recientes</h3>
                    <p class="muted-text">Filtra por dentista, paciente, orden o teléfono.</p>
                </div>
                <form method="get" class="admin-search row g-2 align-items-center">
                    <div class="col">
                        <input type="text" name="q" class="form-control" value="<?= esc($searchQuery ?? '') ?>" placeholder="Buscar orden">
                    </div>
                    <div class="col-12 col-sm-auto">
                        <button type="submit" class="btn btn-primary btn-small w-100">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
            <table class="admin-table table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Dentista</th>
                        <th>Paciente</th>
                        <th>Estatus</th>
                        <th>Entrega</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7">No hay órdenes registradas todavía.</td>
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
                                <td><span class="status-pill status-<?= esc($order['status'] ?? 'recibida') ?>"><?= esc(pot_order_status_label($order['status'] ?? 'recibida')) ?></span></td>
                                <td><?= esc($order['required_date']) ?></td>
                                <td><?= esc(site_datetime($order['created_at'] ?? null)) ?></td>
                                <td>
                                    <?php if (admin_can_edit_orders()): ?>
                                        <a href="<?= base_url('admin/ordenes/editar/' . $order['id']) ?>" class="btn btn-outline btn-small admin-action-icon" aria-label="Editar orden" title="Editar orden"><i class="fa-solid fa-pen"></i></a>
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

        <aside class="admin-side-column">
            <div class="table-card admin-mini-panel">
                <h3>Resumen operativo</h3>
                <div class="admin-progress-list">
                    <div class="admin-progress-row">
                        <span>Recibidas</span>
                        <strong><?= esc((string) $receivedCount) ?></strong>
                    </div>
                    <div class="admin-progress-row">
                        <span>En proceso</span>
                        <strong><?= esc((string) $inProgressCount) ?></strong>
                    </div>
                    <div class="admin-progress-row">
                        <span>Listas</span>
                        <strong><?= esc((string) $readyCount) ?></strong>
                    </div>
                    <div class="admin-progress-row">
                        <span>Canceladas</span>
                        <strong><?= esc((string) $cancelledCount) ?></strong>
                    </div>
                </div>
            </div>

            <div class="table-card admin-mini-panel admin-mini-panel-dark">
                <h3>Foco del día</h3>
                <p>Prioriza las órdenes en proceso y las listas para entrega para mantener salida estable y comunicación clara con clínica.</p>
                <div class="admin-mini-panel-badge">Marca POT</div>
            </div>
        </aside>
    </div>
</section>
<?= $this->endSection() ?>
