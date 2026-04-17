<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Estamos Para Servirle</span>
        <h1>Contáctenos</h1>
        <p>Nuestro equipo está listo para atender sus consultas y brindarle la mejor asesoría profesional.</p>
    </div>
</section>

<section class="section">
    <div class="container cards-grid contact-grid">
        <article class="mini-card">
            <h3>Teléfono</h3>
            <p><a href="tel:+523334735108">(33) 3473-5108</a></p>
        </article>
        <article class="mini-card">
            <h3>WhatsApp</h3>
            <p><a href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">(33) 1130-0050</a></p>
        </article>
        <article class="mini-card">
            <h3>Email</h3>
            <p><a href="mailto:contacto@potprotesisdental.com">contacto@potprotesisdental.com</a></p>
        </article>
        <article class="mini-card">
            <h3>Horario</h3>
            <p>Lun - Vie: 10:00 - 14:00 / 16:00 - 20:00</p>
        </article>
    </div>
</section>

<section class="section muted">
    <div class="container split">
        <div class="content-block">
            <h2>Nuestra Ubicación</h2>
            <p>C. Reforma 1752<br>Ladrón de Guevara<br>44600 Guadalajara, Jalisco</p>
        </div>
        <div class="map-placeholder">
            <p>Mapa e integración se migrarán en una fase posterior.</p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
