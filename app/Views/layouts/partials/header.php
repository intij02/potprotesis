<?php
$currentPath = current_url(true)->getPath();
$navItems = [
    '/' => 'Inicio',
    'servicios' => 'Servicios',
    'galeria' => 'Galería',
    'orden-laboratorio' => 'Orden',
    'contacto' => 'Contacto',
];
?>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= base_url('/') ?>">
            <img src="<?= base_url('assets/media/logo-pot.png') ?>" alt="POT Prótesis Dental">
        </a>
        <nav class="main-nav">
            <?php foreach ($navItems as $href => $label): ?>
                <?php
                $target = trim($href, '/');
                $isActive = ($target === '' && ($currentPath === '' || $currentPath === '/'))
                    || trim($currentPath, '/') === $target;
                ?>
                <a href="<?= base_url($href) ?>" class="<?= $isActive ? 'active' : '' ?>">
                    <?= esc($label) ?>
                </a>
            <?php endforeach; ?>
            <a class="btn btn-primary btn-small" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">
                Contactar
            </a>
        </nav>
    </div>
</header>
