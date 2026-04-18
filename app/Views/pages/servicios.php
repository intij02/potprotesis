<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Servicios Profesionales</span>
        <h1>Soluciones Completas en Prótesis Dental</h1>
        <p>Ofrecemos una amplia gama de servicios especializados con altos estándares de calidad y precisión técnica.</p>
    </div>
</section>

<section class="section">
<?php foreach ($services as $index => $service): ?>
<section class="section<?= $index % 2 === 1 ? ' muted' : '' ?>">
    <div class="container split<?= $index % 2 === 1 ? ' reverse' : '' ?>">
        <div class="media-block">
            <img src="<?= base_url($service['image_path'] ?: 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="<?= esc($service['title']) ?>">
        </div>
        <div class="content-block">
            <span class="eyebrow"><?= $index % 2 === 0 ? 'Servicio Especializado' : 'Solución Protésica' ?></span>
            <h2><?= esc($service['title']) ?></h2>
            <p><?= esc($service['summary']) ?></p>
        </div>
    </div>
</section>
<?php endforeach; ?>
<?= $this->endSection() ?>
