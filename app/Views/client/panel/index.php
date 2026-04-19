<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container narrow">
        <span class="eyebrow">Panel Cliente</span>
        <h1><?= esc($client['name'] ?? 'Cliente') ?></h1>
        <p>Consulta el estado actual de tus órdenes registradas en POT.</p>
        <div class="hero-actions">
            <a href="<?= base_url('cliente/pacientes') ?>" class="btn btn-primary btn-small">Administrar pacientes</a>
            <a href="<?= base_url('cliente/logout') ?>" class="btn btn-outline btn-small">Cerrar sesión</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="cards-grid mb-4">
            <article class="mini-card">
                <span class="eyebrow">Pacientes</span>
                <h2><?= esc((string) $patientCount) ?></h2>
                <p>Pacientes registrados en tu cuenta para asociarlos a nuevas órdenes.</p>
            </article>
            <article class="mini-card">
                <span class="eyebrow">Órdenes</span>
                <h2><?= esc((string) count($orders)) ?></h2>
                <p>Órdenes visibles actualmente dentro de tu panel de cliente.</p>
            </article>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="admin-table table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Paciente</th>
                            <th>Estatus</th>
                            <th>Entrega</th>
                            <th>Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orders === []): ?>
                            <tr><td colspan="5">No hay órdenes registradas para este cliente.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= esc($order['order_number'] ?: '#' . $order['id']) ?></td>
                                    <td><?= esc($order['patient_name']) ?></td>
                                    <td><span class="status-pill status-<?= esc($order['status'] ?? 'recibida') ?>"><?= esc(pot_order_status_label($order['status'] ?? 'recibida')) ?></span></td>
                                    <td><?= esc($order['required_date']) ?></td>
                                    <td><?= esc(site_datetime($order['created_at'] ?? null)) ?></td>
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
