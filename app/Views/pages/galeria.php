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
    <div class="container">
        <div class="row g-4">
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Corona de porcelana">
            <figcaption>Corona de Porcelana</figcaption>
        </figure>
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Puente fijo">
            <figcaption>Puente Fijo</figcaption>
        </figure>
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Corona sobre implante">
            <figcaption>Corona sobre Implante</figcaption>
        </figure>
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Prótesis removible">
            <figcaption>Prótesis Removible</figcaption>
        </figure>
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Restauración estética">
            <figcaption>Restauración Estética</figcaption>
        </figure>
        <figure class="col-12 col-md-6 col-xl-4">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Proceso de fabricación">
            <figcaption>Proceso de Fabricación</figcaption>
        </figure>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
