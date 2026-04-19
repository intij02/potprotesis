<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Acceso Cliente</span>
        <h1>Consulta el estatus de tus órdenes</h1>
        <p>Ingresa con el email y contraseña asignados a tu cuenta de cliente.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= base_url('cliente/login') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" class="form-control" type="email" value="<?= esc(old('email', '')) ?>" required>
                </div>

                <div>
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" name="password" class="form-control" type="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
