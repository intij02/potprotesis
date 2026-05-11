<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero" style="padding: 2rem 0 2rem 0;">
    <div class="container center narrow">
        <span class="eyebrow">Servicios Profesionales</span>
        <h1>Soluciones Completas en Prótesis Dental</h1>
        <p>Ofrecemos una amplia gama de servicios especializados con altos estándares de calidad y precisión técnica.</p>
    </div>
</section>

<section class="section" style="padding: 2rem 0 2rem 0;">
<?php foreach ($services as $index => $service): ?>
<?php $serviceUrl = base_url('servicios/' . site_slugify((string) ($service['slug'] ?? $service['title'] ?? ''), 'servicio')); ?>
<section class="section<?= $index % 2 === 1 ? ' muted' : '' ?>">
    <div class="container split<?= $index % 2 === 1 ? ' reverse' : '' ?>">
        <div class="media-block">
            <a href="<?= $serviceUrl ?>">
                <img src="<?= base_url($service['image_path'] ?: 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="<?= esc($service['title']) ?>">
            </a>
        </div>
        <div class="content-block">
            <span class="eyebrow"><?= $index % 2 === 0 ? 'Servicio Especializado' : 'Solución Protésica' ?></span>
            <h2><a href="<?= $serviceUrl ?>" class="text-reset text-decoration-none"><?= esc($service['title']) ?></a></h2>
            <p><?= esc($service['summary']) ?></p>
            <p><a href="<?= $serviceUrl ?>" class="btn btn-outline btn-small">Ver detalle</a></p>
        </div>
    </div>
</section>
<?php endforeach; ?>
</section>
<?= $this->endSection() ?>
