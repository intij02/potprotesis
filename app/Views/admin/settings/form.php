<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container narrow">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow">CMS</span>
                <h1>Configuración del sitio</h1>
                <p>Administre datos de contacto, mapa y destinatario del formulario.</p>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="admin-card admin-form-card">
            <form method="post" class="stack-form" action="<?= base_url('admin/configuracion') ?>">
                <?= csrf_field() ?>
                <div>
                    <label for="contact_phone" class="form-label">Teléfono visible</label>
                    <input id="contact_phone" name="contact_phone" class="form-control" type="text" value="<?= esc($settings['contact_phone']) ?>" required>
                </div>
                <div>
                    <label for="contact_phone_href" class="form-label">Teléfono para enlace `tel:`</label>
                    <input id="contact_phone_href" name="contact_phone_href" class="form-control" type="text" value="<?= esc($settings['contact_phone_href']) ?>" required>
                </div>
                <div>
                    <label for="contact_whatsapp" class="form-label">WhatsApp visible</label>
                    <input id="contact_whatsapp" name="contact_whatsapp" class="form-control" type="text" value="<?= esc($settings['contact_whatsapp']) ?>" required>
                </div>
                <div>
                    <label for="contact_whatsapp_href" class="form-label">WhatsApp para enlace</label>
                    <input id="contact_whatsapp_href" name="contact_whatsapp_href" class="form-control" type="text" value="<?= esc($settings['contact_whatsapp_href']) ?>" required>
                </div>
                <div>
                    <label for="contact_email" class="form-label">Email público</label>
                    <input id="contact_email" name="contact_email" class="form-control" type="email" value="<?= esc($settings['contact_email']) ?>" required>
                </div>
                <div>
                    <label for="contact_form_recipient_email" class="form-label">Email receptor del formulario</label>
                    <input id="contact_form_recipient_email" name="contact_form_recipient_email" class="form-control" type="email" value="<?= esc($settings['contact_form_recipient_email']) ?>" required>
                </div>
                <div>
                    <label for="contact_address" class="form-label">Dirección</label>
                    <input id="contact_address" name="contact_address" class="form-control" type="text" value="<?= esc($settings['contact_address']) ?>" required>
                </div>
                <div>
                    <label for="contact_hours" class="form-label">Horario</label>
                    <input id="contact_hours" name="contact_hours" class="form-control" type="text" value="<?= esc($settings['contact_hours']) ?>" required>
                </div>
                <div>
                    <label for="contact_map_embed_url" class="form-label">URL embed de Google Maps</label>
                    <textarea id="contact_map_embed_url" name="contact_map_embed_url" class="form-control" rows="4" required><?= esc($settings['contact_map_embed_url']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar configuración</button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
