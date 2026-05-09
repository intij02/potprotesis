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
        <?php $validation = session('_ci_validation'); ?>
        <?php if ($validation && $validation->getErrors()): ?>
            <div class="alert alert-danger">
                <?php foreach ($validation->getErrors() as $validationError): ?>
                    <div><?= esc($validationError) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= base_url('cliente/registro') ?>" id="client-register-form" novalidate>
                <?= csrf_field() ?>
                <div class="contact-honeypot" aria-hidden="true">
                    <label for="company_website">Dejar en blanco</label>
                    <input id="company_website" name="company_website" type="text" tabindex="-1" autocomplete="new-password" value="">
                </div>

                <div>
                    <label for="name" class="form-label">Nombre o clínica</label>
                    <input id="name" name="name" class="form-control" type="text" value="<?= esc(old('name', '')) ?>" required autofocus>
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
                    <div class="password-field">
                        <input id="password" name="password" class="form-control" type="password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false" title="Mostrar contraseña">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Zm11 4.5a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                    <div class="password-field">
                        <input id="password_confirm" name="password_confirm" class="form-control" type="password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password_confirm" aria-label="Mostrar contraseña" aria-pressed="false" title="Mostrar contraseña">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Zm11 4.5a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z"/></svg>
                        </button>
                    </div>
                    <p class="field-error" id="password-confirm-error" hidden>Las contraseñas no coinciden.</p>
                </div>

                <button type="submit" class="btn btn-primary">Crear cuenta</button>
            </form>

            <p class="auth-alt-link">¿Ya tienes cuenta? <a href="<?= base_url('cliente/login') ?>">Inicia sesión aquí</a>.</p>
        </div>
    </div>
</section>

<script>
    (() => {
        const form = document.getElementById('client-register-form');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirm');
        const passwordError = document.getElementById('password-confirm-error');

        if (!form || !passwordInput || !passwordConfirmInput || !passwordError) {
            return;
        }

        const validatePasswords = () => {
            const passwordsMatch = passwordInput.value === passwordConfirmInput.value;
            const showMismatch = passwordConfirmInput.value !== '' && !passwordsMatch;

            passwordConfirmInput.setCustomValidity(showMismatch ? 'Las contraseñas no coinciden.' : '');
            passwordError.hidden = !showMismatch;
        };

        passwordInput.addEventListener('input', validatePasswords);
        passwordConfirmInput.addEventListener('input', validatePasswords);

        form.addEventListener('submit', (event) => {
            validatePasswords();

            if (!form.reportValidity()) {
                event.preventDefault();
            }
        });
    })();
</script>
<?= $this->endSection() ?>
