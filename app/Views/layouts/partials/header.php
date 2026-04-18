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
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light site-navbar px-0">
            <a class="navbar-brand brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/media/logo-pot.png') ?>" alt="POT Prótesis Dental">
            </a>
            <button class="navbar-toggler site-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavigation" aria-controls="siteNavigation" aria-expanded="false" aria-label="Abrir menú de navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse main-nav-wrap" id="siteNavigation">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <?php foreach ($navItems as $href => $label): ?>
                        <?php
                        $target = trim($href, '/');
                        $isActive = ($target === '' && ($currentPath === '' || $currentPath === '/'))
                            || trim($currentPath, '/') === $target;
                        ?>
                        <a href="<?= base_url($href) ?>" class="nav-link main-nav-link <?= $isActive ? 'active' : '' ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                            <?= esc($label) ?>
                        </a>
                    <?php endforeach; ?>
                    <a class="btn btn-primary btn-small main-nav-cta" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">
                        Contactar
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
