<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="admin-login">
    <div class="admin-card">
        <span class="eyebrow">Acceso Restringido</span>
        <h1>Admin POT</h1>
        <p>Inicia sesión para consultar, editar y eliminar órdenes del laboratorio.</p>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <form class="stack-form" method="post" action="<?= base_url('admin/login') ?>">
            <?= csrf_field() ?>
            <div>
                <label for="username">Usuario</label>
                <input id="username" name="username" type="text" value="<?= old('username') ?>" placeholder="Usuario">
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
