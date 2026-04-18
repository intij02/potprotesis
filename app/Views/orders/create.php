<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Captura Digital</span>
        <h1>Orden de laboratorio POT</h1>
        <p>Versión digital del formato físico para recibir trabajos, dientes, restauraciones, implantes y observaciones.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (session('success')): ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>

        <?php if ($validation->getErrors() !== []): ?>
            <div class="alert alert-danger">Revise los campos marcados antes de guardar la orden.</div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('/orden-laboratorio') ?>" class="order-form">
            <?= csrf_field() ?>

            <div class="order-panel order-panel-primary">
                <div class="order-panel-head">
                    <h2>Datos generales</h2>
                    <p>Información base de la orden y del caso clínico.</p>
                </div>

                    <div class="row g-3 order-grid order-grid-general">
                        <div class="field">
                        <label for="order_number" class="form-label">Número de orden</label>
                        <input id="order_number" name="order_number" class="form-control" type="text" value="<?= esc($formData['order_number']) ?>" placeholder="Opcional">
                        <?php if ($validation->hasError('order_number')): ?>
                            <p class="field-error"><?= esc($validation->getError('order_number')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="sent_date" class="form-label">Fecha de envío</label>
                        <input id="sent_date" name="sent_date" class="form-control" type="date" value="<?= esc($formData['sent_date']) ?>">
                        <?php if ($validation->hasError('sent_date')): ?>
                            <p class="field-error"><?= esc($validation->getError('sent_date')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="required_date" class="form-label">Fecha requerida</label>
                        <input id="required_date" name="required_date" class="form-control" type="date" value="<?= esc($formData['required_date']) ?>">
                        <?php if ($validation->hasError('required_date')): ?>
                            <p class="field-error"><?= esc($validation->getError('required_date')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="dentist_name" class="form-label">Dentista</label>
                        <input id="dentist_name" name="dentist_name" class="form-control" type="text" value="<?= esc($formData['dentist_name']) ?>">
                        <?php if ($validation->hasError('dentist_name')): ?>
                            <p class="field-error"><?= esc($validation->getError('dentist_name')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="patient_name" class="form-label">Paciente</label>
                        <input id="patient_name" name="patient_name" class="form-control" type="text" value="<?= esc($formData['patient_name']) ?>">
                        <?php if ($validation->hasError('patient_name')): ?>
                            <p class="field-error"><?= esc($validation->getError('patient_name')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="contact_phone" class="form-label">Teléfono de contacto</label>
                        <input id="contact_phone" name="contact_phone" class="form-control" type="text" value="<?= esc($formData['contact_phone']) ?>">
                        <?php if ($validation->hasError('contact_phone')): ?>
                            <p class="field-error"><?= esc($validation->getError('contact_phone')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field field-wide">
                        <label for="shade" class="form-label">Color</label>
                        <input id="shade" name="shade" class="form-control" type="text" value="<?= esc($formData['shade']) ?>" placeholder="Ej. A2, B1, Bleach">
                        <?php if ($validation->hasError('shade')): ?>
                            <p class="field-error"><?= esc($validation->getError('shade')) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="order-split">
                <div class="order-panel">
                    <div class="order-panel-head">
                        <h2>Trabajo a realizar</h2>
                        <p>Seleccione uno o más trabajos del formato original.</p>
                    </div>

                    <div class="check-grid">
                        <?php foreach ($workTypes as $workType): ?>
                            <label class="check-tile">
                                <input type="checkbox" name="work_types[]" value="<?= esc($workType) ?>" <?= in_array($workType, $formData['work_types'], true) ? 'checked' : '' ?>>
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
                        <p>Tipo de restauración y configuración de prótesis sobre implante.</p>
                    </div>

                    <div class="stack-block">
                        <p class="block-label">Restauración</p>
                        <div class="check-grid compact">
                            <?php foreach ($restorationTypes as $restorationType): ?>
                                <label class="check-tile">
                                    <input type="checkbox" name="restoration_types[]" value="<?= esc($restorationType) ?>" <?= in_array($restorationType, $formData['restoration_types'], true) ? 'checked' : '' ?>>
                                    <span><?= esc($restorationType) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="implant-box">
                        <label class="inline-check">
                            <input type="checkbox" name="implant_case" value="1" <?= $formData['implant_case'] ? 'checked' : '' ?>>
                            <span>Prótesis sobre implante</span>
                        </label>

                        <div class="radio-grid">
                            <?php foreach ($implantOptions as $implantValue => $implantLabel): ?>
                                <label class="check-tile">
                                    <input type="radio" name="implant_chimney" value="<?= esc($implantValue) ?>" <?= $formData['implant_chimney'] === $implantValue ? 'checked' : '' ?>>
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
                    <p>Capture las piezas dentales del caso usando la nomenclatura FDI.</p>
                </div>

                <div class="teeth-card">
                    <div class="teeth-meta">
                        <span class="teeth-badge">FDI</span>
                        <span><?= count($formData['selected_teeth']) ?> diente(s) seleccionado(s)</span>
                    </div>

                    <div class="teeth-group">
                        <p class="block-label">Arcada superior</p>
                        <div class="teeth-grid">
                            <?php foreach ($upperTeeth as $tooth): ?>
                                <label class="tooth-tile">
                                    <span><?= esc($tooth) ?></span>
                                    <input type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
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
                                    <input type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
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
                    <div class="order-panel-head">
                        <h2>Observaciones</h2>
                        <p>Indicaciones clínicas, notas de material y detalles adicionales del caso.</p>
                    </div>

                    <div class="field">
                        <label for="observations" class="form-label">Observaciones de laboratorio</label>
                        <textarea id="observations" name="observations" class="form-control" rows="7" placeholder="Instrucciones, detalles estéticos, referencias del caso, etc."><?= esc($formData['observations']) ?></textarea>
                        <?php if ($validation->hasError('observations')): ?>
                            <p class="field-error"><?= esc($validation->getError('observations')) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="signature_name" class="form-label">Nombre y firma</label>
                        <input id="signature_name" name="signature_name" class="form-control" type="text" value="<?= esc($formData['signature_name']) ?>" placeholder="Nombre de quien autoriza la orden">
                        <?php if ($validation->hasError('signature_name')): ?>
                            <p class="field-error"><?= esc($validation->getError('signature_name')) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <aside class="order-submit-card">
                    <h3>Guardar orden</h3>
                    <p>El formulario se valida en servidor y queda listo para persistirse en MySQL desde `CI4`.</p>
                    <button type="submit" class="btn btn-secondary order-submit">Guardar orden</button>
                    <a href="<?= site_url('/orden-laboratorio') ?>" class="btn btn-outline order-submit">Limpiar formulario</a>
                </aside>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
