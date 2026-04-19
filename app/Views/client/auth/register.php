<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Nuevo Cliente</span>
        <h1>Registra tu cuenta de cliente</h1>
        <p>Crea tu acceso y activa tu cuenta desde el enlace que recibirás por correo electrónico.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= base_url('cliente/registro') ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="name" class="form-label">Nombre o clínica</label>
                    <input id="name" name="name" class="form-control" type="text" value="<?= esc(old('name', '')) ?>" required>
                </div>

                <div>
                    <label for="contact_phone" class="form-label">Teléfono</label>
                    <input id="contact_phone" name="contact_phone" class="form-control" type="text" value="<?= esc(old('contact_phone', '')) ?>">
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" class="form-control" type="email" value="<?= esc(old('email', '')) ?>" required>
                </div>

                <div>
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" name="password" class="form-control" type="password" required>
                </div>

                <div>
                    <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                    <input id="password_confirm" name="password_confirm" class="form-control" type="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Crear cuenta</button>
            </form>

            <p class="auth-alt-link">¿Ya tienes cuenta? <a href="<?= base_url('cliente/login') ?>">Inicia sesión aquí</a>.</p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
