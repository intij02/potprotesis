<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Admin POT') ?></title>
    <meta name="description" content="<?= esc($metaDescription ?? 'Administración POT') ?>">
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="admin-body">
    <header class="admin-shell-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light admin-navbar px-0">
                <div>
                    <a class="navbar-brand fw-bold" href="<?= base_url('admin/ordenes') ?>">Panel POT</a>
                    <?php if (admin_is_logged_in()): ?>
                        <div class="muted-text small">
                            <?= esc(admin_auth_user()['full_name'] ?? admin_auth_user()['username'] ?? 'Usuario') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (admin_is_logged_in()): ?>
                    <button class="navbar-toggler site-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavigation" aria-controls="adminNavigation" aria-expanded="false" aria-label="Abrir menú del panel">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-lg-end admin-nav-wrap" id="adminNavigation">
                        <div class="navbar-nav admin-shell-nav ms-auto">
                            <a class="nav-link" href="<?= base_url('admin/ordenes') ?>">Órdenes</a>
                            <?php if (admin_can_manage_users()): ?>
                                <a class="nav-link" href="<?= base_url('admin/usuarios') ?>">Usuarios</a>
                                <a class="nav-link" href="<?= base_url('admin/clientes') ?>">Clientes</a>
                                <a class="nav-link" href="<?= base_url('admin/pacientes') ?>">Pacientes</a>
                                <a class="nav-link" href="<?= base_url('admin/servicios') ?>">Servicios</a>
                                <a class="nav-link" href="<?= base_url('admin/blog') ?>">Blog</a>
                                <a class="nav-link" href="<?= base_url('admin/galeria') ?>">Galería</a>
                                <a class="nav-link" href="<?= base_url('admin/configuracion') ?>">Configuración</a>
                                <a class="nav-link" href="<?= base_url('admin/mensajes-contacto') ?>">Mensajes</a>
                            <?php endif; ?>
                            <a class="nav-link" href="<?= base_url('admin/logout') ?>">Cerrar sesión</a>
                        </div>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <?= $this->renderSection('content') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        (() => {
            const loadingText = 'Enviando...';
            const openEyePath = 'M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Zm11 4.5a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z';
            const closedEyePath = 'm3 4.27 17.73 17.73-1.41 1.41-3.11-3.11A12.92 12.92 0 0 1 12 19.5C7 19.5 2.73 16.39 1 12a13.7 13.7 0 0 1 4.05-5.37L1.59 5.68 3 4.27Zm6.02 6.02A4.48 4.48 0 0 0 7.5 12a4.5 4.5 0 0 0 6.21 4.16l-1.53-1.53A2.5 2.5 0 0 1 9.37 11.8l-.35-.35Zm10.86 5.2L17.3 12.9c.13-.29.2-.59.2-.9A4.5 4.5 0 0 0 11.1 7.7L8.79 5.39A13.09 13.09 0 0 1 12 4.5c5 0 9.27 3.11 11 7.5a13.7 13.7 0 0 1-3.12 3.49Z';

            document.querySelectorAll('[data-password-toggle]').forEach((toggleButton) => {
                const targetId = toggleButton.getAttribute('data-password-toggle');
                const input = targetId ? document.getElementById(targetId) : null;
                const iconPath = toggleButton.querySelector('path');

                if (!input || !iconPath) {
                    return;
                }

                toggleButton.addEventListener('click', () => {
                    const isVisible = input.type === 'text';

                    input.type = isVisible ? 'password' : 'text';
                    toggleButton.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
                    toggleButton.setAttribute('aria-label', isVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
                    toggleButton.setAttribute('title', isVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
                    iconPath.setAttribute('d', isVisible ? openEyePath : closedEyePath);
                });
            });

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (event.defaultPrevented) {
                        return;
                    }

                    const submitButton = event.submitter ?? form.querySelector('button[type="submit"], input[type="submit"]');

                    if (!submitButton || submitButton.dataset.loadingApplied === 'true') {
                        return;
                    }

                    submitButton.dataset.loadingApplied = 'true';
                    submitButton.disabled = true;
                    submitButton.classList.add('is-loading');

                    if (submitButton.tagName === 'BUTTON') {
                        if (!submitButton.dataset.originalLabel) {
                            submitButton.dataset.originalLabel = submitButton.innerHTML;
                        }

                        submitButton.innerHTML = '<span class="btn-spinner" aria-hidden="true"></span><span>' + loadingText + '</span>';
                    } else if (submitButton instanceof HTMLInputElement) {
                        if (!submitButton.dataset.originalValue) {
                            submitButton.dataset.originalValue = submitButton.value;
                        }

                        submitButton.value = loadingText;
                    }
                });
            });
        })();
    </script>
</body>
</html>
