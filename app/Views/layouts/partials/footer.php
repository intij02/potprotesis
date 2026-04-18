<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <img class="footer-logo" src="<?= base_url('assets/media/logo-pot.png') ?>" alt="POT Prótesis Dental">
            <p>Laboratorio especializado en prótesis dental de alta calidad para dentistas y clínicas en Guadalajara.</p>
        </div>
        <div>
            <h3>Servicios</h3>
            <ul>
                <li><a href="<?= base_url('servicios') ?>">Coronas y Puentes</a></li>
                <li><a href="<?= base_url('servicios') ?>">Prótesis Removibles</a></li>
                <li><a href="<?= base_url('servicios') ?>">Implantes Dentales</a></li>
                <li><a href="<?= base_url('galeria') ?>">Galería de Trabajos</a></li>
            </ul>
        </div>
        <div>
            <h3>Contacto</h3>
            <ul>
                <li><a href="tel:<?= esc(site_setting('contact_phone_href', '+523334735108')) ?>"><?= esc(site_setting('contact_phone', '(33) 3473-5108')) ?></a></li>
                <li><a href="https://wa.me/<?= esc(site_setting('contact_whatsapp_href', '523311300050')) ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a></li>
                <li><?= esc(site_setting('contact_address', 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.')) ?></li>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>© <?= date('Y') ?> POT Prótesis Dental. Todos los derechos reservados.</p>
        <nav>
            <a href="<?= base_url('privacidad') ?>">Privacidad</a>
            <a href="<?= base_url('terminos') ?>">Términos</a>
        </nav>
    </div>
</footer>
