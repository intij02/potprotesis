<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Acceso Cliente</span>
        <h1>Consulta el estatus de tus órdenes</h1>
        <p>Ingresa con el email y contraseña de tu cuenta de cliente.</p>
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
                    <div class="password-field">
                        <input id="password" name="password" class="form-control" type="password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false" title="Mostrar contraseña">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Zm11 4.5a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-6 d-grid">
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </div>
                </div>
            </form>

            <p class="auth-alt-link">¿Cliente nuevo? <a href="<?= base_url('cliente/registro') ?>">Crea tu cuenta aquí</a>.</p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
