<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero" style="padding: 2rem 0 2rem 0;">
    <div class="container center narrow">
        <h1><?= esc($service['title']) ?></h1>
    </div>
</section>

<section class="section" style="padding: 2rem 0 2rem 0;">
    <div class="container">
        <div class="split align-items-start" style="gap: 1rem">
            <div class="media-block">
                <img src="<?= base_url($detailImages[0] ?? ($service['image_path'] ?? 'assets/media/logo-pot.png')) ?>" alt="<?= esc($service['title']) ?>">
            </div>
            <div class="content-block">
                <div class="mini-card mb-3" style="padding: 1rem; border-radius: 10px;">
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
        <h2>Algunos trabajos de <span class="text-brand">POT</span></h2>
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
