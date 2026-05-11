<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="admin-login auth-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 auth-container">
                <div class="admin-card">
                    <span class="eyebrow eyebrow-aqua">Acceso al Panel</span>
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
                            <div class="password-field">
                                <input id="password" name="password" class="form-control" type="password" placeholder="Contraseña" required>
                                <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false" title="Mostrar contraseña">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Zm11 4.5a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/></svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 auth-submit">Iniciar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
