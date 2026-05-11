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
        </div>
        <div class="stats">
            <div><strong>15+</strong><span>Años de Experiencia</span></div>
            <div><strong>5000+</strong><span>Casos Realizados</span></div>
            <div><strong>100%</strong><span>Satisfacción</span></div>
        </div>
    </div>
</section>


<section class="section">
    <div class="container section-head center">
        <h2>Nuestros Servicios</h2>
        <p>Soluciones profesionales en prótesis dental con los más altos estándares de calidad.</p>
    </div>
    <div class="container cards-grid">
        <?php foreach ($services as $service): ?>
            <article class="service-card">
                <a href="<?= base_url('servicios/' . ($service['slug'] ?? '')) ?>" class="text-decoration-none">
                    <img src="<?= base_url($service['image_path'] ?: 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg') ?>" alt="<?= esc($service['title']) ?>">
                </a>
                <div class="card-body">
                    <h3><a href="<?= base_url('servicios/' . ($service['slug'] ?? '')) ?>" class="text-reset text-decoration-none text-center"><?= esc($service['title']) ?></a></h3>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php if (! empty($blogPosts)): ?>
<section class="section">
    <div class="container section-head center">
        <h2>Blog</h2>
        <p>Las últimas entradas del laboratorio para clientes y clínicas.</p>
    </div>
    <div class="container">
        <?php foreach ($blogPosts as $post): ?>
            <article class="card mb-3 border-0 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>">
                            <img src="<?= base_url($post['image_path'] ?: 'assets/media/logo-pot.png') ?>" class="img-fluid rounded-start h-100 w-100 object-fit-cover" alt="<?= esc($post['title']) ?>">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body h-100 d-flex flex-column">
                            <h3 class="card-title"><a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="text-reset text-decoration-none"><?= esc($post['title']) ?></a></h3>
                            <p class="card-text"><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content']))), 0, 180)) ?><?= mb_strlen(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content'])))) > 180 ? '…' : '' ?></p>
                            <div class="mt-auto d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                <p class="card-text mb-0"><small class="text-body-secondary"><?= esc(site_datetime($post['created_at'] ?? null, 'd/m/Y')) ?></small></p>
                                <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="btn btn-outline btn-small">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

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
        <?php foreach ($galleryItems as $item): ?>
            <img src="<?= base_url($item['image_path']) ?>" alt="<?= esc($item['alt_text'] ?: $item['title']) ?>">
        <?php endforeach; ?>
    </div>
</section>

<section class="section cta">
    <div class="container center">
        <h2>¿Listo para Trabajar con Nosotros?</h2>
        <p>Contáctenos hoy y descubra por qué somos el laboratorio de confianza para dentistas en Guadalajara.</p>
        <a class="btn btn-secondary" href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">Solicitar Cotización</a>
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
<?= $this->endSection() ?>
