<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Nuestros Trabajos</span>
        <h1>Galería de Casos Realizados</h1>
        <p>Ejemplos de calidad, precisión técnica y atención al detalle en cada trabajo protésico.</p>
    </div>
</section>

<section class="section">
    <div class="container gallery-grid gallery-grid-large">
        <?php foreach ($galleryItems as $item): ?>
            <figure>
                <img src="<?= base_url($item['image_path']) ?>" alt="<?= esc($item['alt_text'] ?: $item['title']) ?>">
                <figcaption><?= esc($item['title']) ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
