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
    <?php if (admin_is_logged_in()): ?>
        <?php
        $currentPath = trim(current_url(true)->getPath(), '/');
        $adminUser = admin_auth_user();
        $navigationMain = [
            [
                'label' => 'Dashboard',
                'href' => base_url('admin/ordenes'),
                'match' => ['admin/ordenes'],
                'icon' => 'fa-solid fa-grid-2',
            ],
        ];
        $navigationGeneral = admin_can_manage_users() ? [
            ['label' => 'Usuarios', 'href' => base_url('admin/usuarios'), 'match' => ['admin/usuarios'], 'icon' => 'fa-solid fa-user-shield'],
            ['label' => 'Clientes', 'href' => base_url('admin/clientes'), 'match' => ['admin/clientes'], 'icon' => 'fa-solid fa-user-group'],
            ['label' => 'Pacientes', 'href' => base_url('admin/pacientes'), 'match' => ['admin/pacientes'], 'icon' => 'fa-solid fa-notes-medical'],
            ['label' => 'Servicios', 'href' => base_url('admin/servicios'), 'match' => ['admin/servicios'], 'icon' => 'fa-solid fa-tooth'],
            ['label' => 'Blog', 'href' => base_url('admin/blog'), 'match' => ['admin/blog'], 'icon' => 'fa-solid fa-newspaper'],
            ['label' => 'Galería', 'href' => base_url('admin/galeria'), 'match' => ['admin/galeria'], 'icon' => 'fa-solid fa-images'],
            ['label' => 'Mensajes', 'href' => base_url('admin/mensajes-contacto'), 'match' => ['admin/mensajes-contacto'], 'icon' => 'fa-solid fa-envelope'],
            ['label' => 'Configuración', 'href' => base_url('admin/configuracion'), 'match' => ['admin/configuracion'], 'icon' => 'fa-solid fa-gear'],
        ] : [];
        ?>
        <div class="admin-shell">
            <aside class="admin-sidebar">
                <div class="admin-sidebar-brand">
                    <a href="<?= base_url('admin/ordenes') ?>" class="admin-sidebar-logo">
                        <span class="admin-sidebar-logo-mark">P</span>
                        <span class="admin-sidebar-logo-text">
                            <strong>Panel POT</strong>
                            <small>Prótesis Dental</small>
                        </span>
                    </a>
                </div>

                <button class="navbar-toggler site-navbar-toggler admin-sidebar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminSidebarNav" aria-controls="adminSidebarNav" aria-expanded="false" aria-label="Abrir menú del panel">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse admin-sidebar-collapse" id="adminSidebarNav">
                    <div class="admin-sidebar-group">
                        <span class="admin-sidebar-title">Menú</span>
                        <nav class="admin-sidebar-nav">
                            <?php foreach ($navigationMain as $item): ?>
                                <?php $isActive = in_array($currentPath, $item['match'], true) || str_starts_with($currentPath, $item['match'][0] . '/'); ?>
                                <a href="<?= $item['href'] ?>" class="admin-sidebar-link<?= $isActive ? ' is-active' : '' ?>">
                                    <i class="<?= esc($item['icon']) ?>" aria-hidden="true"></i>
                                    <span><?= esc($item['label']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </nav>
                    </div>

                    <?php if ($navigationGeneral !== []): ?>
                        <div class="admin-sidebar-group">
                            <span class="admin-sidebar-title">General</span>
                            <nav class="admin-sidebar-nav">
                                <?php foreach ($navigationGeneral as $item): ?>
                                    <?php $isActive = in_array($currentPath, $item['match'], true) || str_starts_with($currentPath, $item['match'][0] . '/'); ?>
                                    <a href="<?= $item['href'] ?>" class="admin-sidebar-link<?= $isActive ? ' is-active' : '' ?>">
                                        <i class="<?= esc($item['icon']) ?>" aria-hidden="true"></i>
                                        <span><?= esc($item['label']) ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </nav>
                        </div>
                    <?php endif; ?>

                    <div class="admin-sidebar-footer">
                        <a href="<?= base_url('admin/logout') ?>" class="admin-sidebar-link admin-sidebar-link-logout">
                            <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </div>
                </div>
            </aside>

            <div class="admin-main">
                <header class="admin-topbar">
                    <div class="admin-topbar-copy">
                        <span class="admin-topbar-kicker">Administración</span>
                        <h1><?= esc($pageTitle ?? 'Admin POT') ?></h1>
                    </div>
                    <div class="admin-topbar-usercard">
                        <div class="admin-topbar-usercard-text">
                            <strong><?= esc($adminUser['full_name'] ?? $adminUser['username'] ?? 'Usuario') ?></strong>
                            <small><?= esc(admin_user_role() === 'admin' ? 'Control total del sistema' : 'Acceso operativo') ?></small>
                        </div>
                        <div class="admin-topbar-avatar"><?= esc(strtoupper(substr((string) ($adminUser['username'] ?? 'A'), 0, 1))) ?></div>
                    </div>
                </header>

                <main class="admin-main-content">
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>
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
