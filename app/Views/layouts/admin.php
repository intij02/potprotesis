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
                                <a class="nav-link" href="<?= base_url('admin/servicios') ?>">Servicios</a>
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
</body>
</html>
