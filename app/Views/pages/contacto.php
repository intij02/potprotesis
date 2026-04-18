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
    <div class="container split">
        <article class="mini-card contact-card-compact">
            <h2>Canales de contacto</h2>
            <p>Puede escribirnos, llamarnos o enviarnos mensaje por WhatsApp. También puede usar el formulario y el mensaje llegará al correo configurado desde administración.</p>
            <div class="contact-stack">
                <div>
                    <strong>Teléfono</strong>
                    <p><a href="tel:<?= esc(site_setting('contact_phone_href', '+523334735108')) ?>"><?= esc(site_setting('contact_phone', '(33) 3473-5108')) ?></a></p>
                </div>
                <div>
                    <strong>WhatsApp</strong>
                    <p><a href="https://wa.me/<?= esc(site_setting('contact_whatsapp_href', '523311300050')) ?>" target="_blank" rel="noopener noreferrer"><?= esc(site_setting('contact_whatsapp', '(33) 1130-0050')) ?></a></p>
                </div>
                <div>
                    <strong>Email</strong>
                    <p><a href="mailto:<?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?>"><?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?></a></p>
                </div>
                <div>
                    <strong>Horario</strong>
                    <p><?= esc(site_setting('contact_hours', 'Lun - Vie: 10:00 - 14:00 / 16:00 - 20:00')) ?></p>
                </div>
                <div>
                    <strong>Dirección</strong>
                    <p><?= esc(site_setting('contact_address', 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.')) ?></p>
                </div>
            </div>
        </article>

        <div class="mini-card contact-card-compact">
            <h2>Escríbanos</h2>
            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')) ?></div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>
            <form method="post" class="stack-form">
                <?= csrf_field() ?>
                <div>
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" name="name" class="form-control" type="text" value="<?= esc($formData['name']) ?>">
                    <?php if ($validation->hasError('name')): ?><p class="field-error"><?= esc($validation->getError('name')) ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" class="form-control" type="email" value="<?= esc($formData['email']) ?>">
                    <?php if ($validation->hasError('email')): ?><p class="field-error"><?= esc($validation->getError('email')) ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="phone" class="form-label">Teléfono</label>
                    <input id="phone" name="phone" class="form-control" type="text" value="<?= esc($formData['phone']) ?>">
                    <?php if ($validation->hasError('phone')): ?><p class="field-error"><?= esc($validation->getError('phone')) ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="message" class="form-label">Mensaje</label>
                    <textarea id="message" name="message" class="form-control" rows="6"><?= esc($formData['message']) ?></textarea>
                    <?php if ($validation->hasError('message')): ?><p class="field-error"><?= esc($validation->getError('message')) ?></p><?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enviar mensaje</button>
            </form>
        </div>
    </div>
</section>

<section class="section muted">
    <div class="container">
        <div class="section-head center">
            <h2>Nuestra Ubicación</h2>
            <p><?= esc(site_setting('contact_address', 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.')) ?></p>
        </div>
        <div class="map-frame-wrap">
            <iframe
                src="<?= esc(site_setting('contact_map_embed_url', 'https://www.google.com/maps?q=C.%20Reforma%201752%2C%20Ladr%C3%B3n%20de%20Guevara%2C%20Guadalajara%2C%20Jalisco&output=embed')) ?>"
                width="100%"
                height="420"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
