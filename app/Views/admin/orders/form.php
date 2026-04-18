<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="eyebrow">Panel Admin</span>
                <h1>Editar orden</h1>
                <p>Solo los administradores pueden actualizar la información de la orden.</p>
            </div>
            <a href="<?= base_url('admin/ordenes') ?>" class="btn btn-outline">Volver</a>
        </div>

        <?php if ($validation->getErrors() !== []): ?>
            <div class="alert alert-danger">Revise los campos marcados antes de guardar la orden.</div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/ordenes/actualizar/' . $order['id']) ?>" class="order-form">
            <?= csrf_field() ?>

            <div class="order-panel">
                <div class="order-panel-head">
                    <h2>Datos generales</h2>
                    <p>Orden #<?= esc($order['order_number'] !== '' ? $order['order_number'] : $order['id']) ?> registrada el <?= esc($order['created_at']) ?></p>
                </div>

                <div class="order-grid order-grid-general">
                    <div class="field">
                        <label for="order_number">Número de orden</label>
                        <input id="order_number" name="order_number" type="text" value="<?= esc($order['order_number']) ?>">
                    </div>
                    <div class="field">
                        <label for="sent_date">Fecha de envío</label>
                        <input id="sent_date" name="sent_date" type="date" value="<?= esc($order['sent_date']) ?>">
                    </div>
                    <div class="field">
                        <label for="required_date">Fecha requerida</label>
                        <input id="required_date" name="required_date" type="date" value="<?= esc($order['required_date']) ?>">
                        <?php if ($validation->hasError('required_date')): ?>
                            <p class="field-error"><?= esc($validation->getError('required_date')) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="dentist_name">Dentista</label>
                        <input id="dentist_name" name="dentist_name" type="text" value="<?= esc($order['dentist_name']) ?>">
                    </div>
                    <div class="field">
                        <label for="patient_name">Paciente</label>
                        <input id="patient_name" name="patient_name" type="text" value="<?= esc($order['patient_name']) ?>">
                    </div>
                    <div class="field">
                        <label for="contact_phone">Teléfono de contacto</label>
                        <input id="contact_phone" name="contact_phone" type="text" value="<?= esc($order['contact_phone']) ?>">
                    </div>
                    <div class="field field-wide">
                        <label for="shade">Color</label>
                        <input id="shade" name="shade" type="text" value="<?= esc($order['shade']) ?>">
                    </div>
                </div>
            </div>

            <div class="order-split">
                <div class="order-panel">
                    <div class="order-panel-head">
                        <h2>Trabajo a realizar</h2>
                    </div>
                    <div class="check-grid">
                        <?php foreach ($workTypes as $workType): ?>
                            <label class="check-tile">
                                <input type="checkbox" name="work_types[]" value="<?= esc($workType) ?>" <?= in_array($workType, $order['work_types'], true) ? 'checked' : '' ?>>
                                <span><?= esc($workType) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($validation->hasError('work_types')): ?>
                        <p class="field-error"><?= esc($validation->getError('work_types')) ?></p>
                    <?php endif; ?>
                </div>

                <div class="order-panel">
                    <div class="order-panel-head">
                        <h2>Restauración e implante</h2>
                    </div>
                    <div class="stack-block">
                        <p class="block-label">Restauración</p>
                        <div class="check-grid compact">
                            <?php foreach ($restorationTypes as $restorationType): ?>
                                <label class="check-tile">
                                    <input type="checkbox" name="restoration_types[]" value="<?= esc($restorationType) ?>" <?= in_array($restorationType, $order['restoration_types'], true) ? 'checked' : '' ?>>
                                    <span><?= esc($restorationType) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="implant-box">
                        <label class="inline-check">
                            <input type="checkbox" name="implant_case" value="1" <?= $order['implant_case'] ? 'checked' : '' ?>>
                            <span>Prótesis sobre implante</span>
                        </label>

                        <div class="radio-grid">
                            <?php foreach ($implantOptions as $implantValue => $implantLabel): ?>
                                <label class="check-tile">
                                    <input type="radio" name="implant_chimney" value="<?= esc($implantValue) ?>" <?= $order['implant_chimney'] === $implantValue ? 'checked' : '' ?>>
                                    <span><?= esc($implantLabel) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($validation->hasError('implant_chimney')): ?>
                            <p class="field-error"><?= esc($validation->getError('implant_chimney')) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="order-panel">
                <div class="order-panel-head">
                    <h2>Selección de dientes</h2>
                </div>

                <div class="teeth-card">
                    <div class="teeth-meta">
                        <span class="teeth-badge">FDI</span>
                        <span><?= count($order['selected_teeth']) ?> diente(s) seleccionado(s)</span>
                    </div>

                    <div class="teeth-group">
                        <p class="block-label">Arcada superior</p>
                        <div class="teeth-grid">
                            <?php foreach ($upperTeeth as $tooth): ?>
                                <label class="tooth-tile">
                                    <span><?= esc($tooth) ?></span>
                                    <input type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?>>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="teeth-group">
                        <p class="block-label">Arcada inferior</p>
                        <div class="teeth-grid">
                            <?php foreach ($lowerTeeth as $tooth): ?>
                                <label class="tooth-tile">
                                    <span><?= esc($tooth) ?></span>
                                    <input type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?>>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php if ($validation->hasError('selected_teeth')): ?>
                    <p class="field-error"><?= esc($validation->getError('selected_teeth')) ?></p>
                <?php endif; ?>
            </div>

            <div class="order-split order-split-bottom">
                <div class="order-panel">
                    <div class="field">
                        <label for="observations">Observaciones</label>
                        <textarea id="observations" name="observations" rows="7"><?= esc($order['observations']) ?></textarea>
                    </div>
                    <div class="field">
                        <label for="signature_name">Nombre y firma</label>
                        <input id="signature_name" name="signature_name" type="text" value="<?= esc($order['signature_name']) ?>">
                    </div>
                </div>

                <aside class="order-submit-card">
                    <h3>Guardar cambios</h3>
                    <p>Los cambios se aplicarán directamente sobre la orden registrada.</p>
                    <button type="submit" class="btn btn-secondary order-submit">Actualizar orden</button>
                </aside>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
