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
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="admin-body">
    <header class="admin-shell-header">
        <div class="container admin-shell-bar">
            <div>
                <strong>Panel POT</strong><br>
                <?php if (admin_is_logged_in()): ?>
                    <span class="muted-text">
                        <?= esc(admin_auth_user()['full_name'] ?? admin_auth_user()['username'] ?? 'Usuario') ?>
                        · <?= esc(admin_user_role() ?? 'sin rol') ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if (admin_is_logged_in()): ?>
                <nav class="admin-shell-nav">
                    <a href="<?= base_url('admin/ordenes') ?>">Órdenes</a>
                    <?php if (admin_can_manage_users()): ?>
                        <a href="<?= base_url('admin/usuarios') ?>">Usuarios</a>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/logout') ?>">Cerrar sesión</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <?= $this->renderSection('content') ?>
</body>
</html>
