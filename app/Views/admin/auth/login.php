<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="admin-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="admin-card">
                    <span class="eyebrow">Acceso al Panel</span>
                    <h1>Admin POT</h1>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
                    <?php endif; ?>
                    <form class="stack-form" method="post" action="<?= base_url('admin/login') ?>">
                        <?= csrf_field() ?>
                        <div>
                            <label for="username" class="form-label">Usuario</label>
                            <input id="username" name="username" class="form-control" type="text" value="<?= old('username') ?>" placeholder="Usuario" autofocus required>
                        </div>
                        <div>
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" name="password" class="form-control" type="password" placeholder="Contraseña" required>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 d-grid">
                                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
