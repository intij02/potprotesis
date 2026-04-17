<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero">
    <div class="hero-media">
        <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Prótesis dental profesional">
        <div class="hero-overlay"></div>
    </div>
    <div class="container hero-content">
        <span class="eyebrow">Laboratorio Profesional</span>
        <h1>Prótesis Dental de Alta Calidad para su Consultorio</h1>
        <p>Elaboramos coronas, puentes y prótesis con precisión técnica y materiales de primera calidad. Servicio profesional para dentistas en Guadalajara.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">Solicitar Información</a>
            <a class="btn btn-outline light" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">WhatsApp</a>
        </div>
        <div class="stats">
            <div><strong>15+</strong><span>Años de Experiencia</span></div>
            <div><strong>5000+</strong><span>Casos Realizados</span></div>
            <div><strong>100%</strong><span>Satisfacción</span></div>
        </div>
    </div>
</section>

<section class="section muted">
    <div class="container three-cols">
        <article class="mini-card">
            <h3>Precisión Técnica</h3>
            <p>Tecnología de última generación y procesos medidos para resultados consistentes.</p>
        </article>
        <article class="mini-card">
            <h3>Materiales Certificados</h3>
            <p>Trabajos elaborados con materiales premium y protocolos de calidad controlados.</p>
        </article>
        <article class="mini-card">
            <h3>Entrega Rápida</h3>
            <p>Tiempos optimizados para responder al ritmo de trabajo del consultorio.</p>
        </article>
    </div>
</section>

<section class="section">
    <div class="container section-head center">
        <h2>Nuestros Servicios</h2>
        <p>Soluciones profesionales en prótesis dental con los más altos estándares de calidad.</p>
    </div>
    <div class="container cards-grid">
        <article class="service-card">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Coronas y puentes">
            <div class="card-body">
                <h3>Coronas y Puentes</h3>
                <p>Restauraciones fijas en porcelana, zirconia y metal-porcelana con estética natural.</p>
            </div>
        </article>
        <article class="service-card">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Prótesis removibles">
            <div class="card-body">
                <h3>Prótesis Removibles</h3>
                <p>Dentaduras parciales y completas con diseño anatómico y enfoque en comodidad.</p>
            </div>
        </article>
        <article class="service-card">
            <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Implantes">
            <div class="card-body">
                <h3>Prótesis sobre Implantes</h3>
                <p>Soluciones avanzadas con máxima estabilidad, ajuste y precisión milimétrica.</p>
            </div>
        </article>
    </div>
</section>

<section class="section muted">
    <div class="container section-head center">
        <h2>Proceso de Trabajo</h2>
        <p>Un flujo de trabajo eficiente para garantizar resultados excepcionales.</p>
    </div>
    <div class="container process-grid">
        <article><span>1</span><h3>Pedido</h3><p>Recibimos su orden con especificaciones detalladas e impresiones.</p></article>
        <article><span>2</span><h3>Elaboración</h3><p>Nuestro equipo técnico fabrica la prótesis con precisión y cuidado.</p></article>
        <article><span>3</span><h3>Entrega</h3><p>Entregamos el trabajo terminado en tiempo y forma a su consultorio.</p></article>
    </div>
</section>

<section class="section">
    <div class="container section-head center">
        <h2>Galería de Trabajos</h2>
        <p>Ejemplos de nuestra calidad y precisión en cada caso.</p>
    </div>
    <div class="container gallery-grid">
        <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Trabajo realizado 1">
        <img src="<?= base_url('assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="Trabajo realizado 2">
        <img src="<?= base_url('assets/media/pages-home-gallery-3-94a5fe60.jpg') ?>" alt="Trabajo realizado 3">
    </div>
</section>

<section class="section cta">
    <div class="container center">
        <h2>¿Listo para Trabajar con Nosotros?</h2>
        <p>Contáctenos hoy y descubra por qué somos el laboratorio de confianza para dentistas en Guadalajara.</p>
        <a class="btn btn-secondary" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">Solicitar Cotización</a>
    </div>
</section>
<?= $this->endSection() ?>
