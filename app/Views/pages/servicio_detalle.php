<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Servicio Especializado</span>
        <h1><?= esc($service['title']) ?></h1>
        <p><?= esc($service['summary']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="split align-items-start">
            <div class="media-block">
                <img src="<?= base_url($detailImages[0] ?? ($service['image_path'] ?? 'assets/media/logo-pot.png')) ?>" alt="<?= esc($service['title']) ?>">
            </div>
            <div class="content-block">
                <span class="eyebrow">Descripción</span>
                <div class="mini-card">
                    <?php foreach (preg_split('/\R{2,}/', trim((string) ($service['detail_content'] ?? $service['summary'] ?? ''))) as $paragraph): ?>
                        <?php if (trim($paragraph) !== ''): ?>
                            <p><?= nl2br(esc(trim($paragraph))) ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <p><a href="<?= base_url('orden-laboratorio') ?>" class="btn btn-primary">Solicitar información</a></p>
            </div>
        </div>
    </div>
</section>

<?php if ($detailImages !== []): ?>
<section class="section muted">
    <div class="container section-head center">
        <h2>Galería del servicio</h2>
        <p>Imágenes relacionadas con este servicio.</p>
    </div>
    <div class="container gallery-grid gallery-grid-large">
        <?php foreach ($detailImages as $imagePath): ?>
            <figure>
                <img src="<?= base_url($imagePath) ?>" alt="<?= esc($service['title']) ?>">
            </figure>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?= $this->endSection() ?>
