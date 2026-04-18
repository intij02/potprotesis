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
    <div class="container">
        <div class="row align-items-center g-5">
        <div class="col-12 col-lg-6">
            <div class="media-block">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Coronas y puentes">
            </div>
        </div>
        <div class="col-12 col-lg-6 content-block">
            <span class="eyebrow">Restauraciones Fijas</span>
            <h2>Coronas y Puentes</h2>
            <p>Restauraciones protésicas fijas de alta precisión que devuelven funcionalidad y estética natural.</p>
            <ul class="feature-list list-unstyled">
                <li>Coronas de porcelana</li>
                <li>Coronas de zirconia</li>
                <li>Metal-porcelana</li>
                <li>Puentes fijos</li>
            </ul>
        </div>
        </div>
    </div>
</section>

<section class="section muted">
    <div class="container">
        <div class="row align-items-center g-5">
        <div class="col-12 col-lg-6 order-lg-2">
            <div class="media-block">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Prótesis removibles">
            </div>
        </div>
        <div class="col-12 col-lg-6 content-block">
            <span class="eyebrow">Soluciones Removibles</span>
            <h2>Prótesis Removibles</h2>
            <p>Dentaduras parciales y completas diseñadas con precisión anatómica para máxima comodidad y funcionalidad.</p>
            <ul class="feature-list list-unstyled">
                <li>Prótesis parciales</li>
                <li>Prótesis totales</li>
                <li>Prótesis flexibles</li>
                <li>Prótesis inmediatas</li>
            </ul>
        </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
        <div class="col-12 col-lg-6">
            <div class="media-block">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Implantes">
            </div>
        </div>
        <div class="col-12 col-lg-6 content-block">
            <span class="eyebrow">Tecnología Avanzada</span>
            <h2>Prótesis sobre Implantes</h2>
            <p>Soluciones protésicas de última generación sobre implantes dentales, con máxima estabilidad y estética natural.</p>
            <ul class="feature-list list-unstyled">
                <li>Coronas sobre implantes</li>
                <li>Puentes sobre implantes</li>
                <li>Prótesis híbridas</li>
                <li>Sobredentaduras</li>
            </ul>
        </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
