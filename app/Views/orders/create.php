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
            <div class="alert alert-danger">
                <?php if ($validation->hasError('form')): ?>
                    <?= esc($validation->getError('form')) ?>
                <?php else: ?>
                    No fue posible guardar la orden. Revise los datos enviados.
                <?php endif; ?>
                <?php $visibleErrors = array_filter($validation->getErrors(), static fn ($key) => $key !== 'form', ARRAY_FILTER_USE_KEY); ?>
                <?php if ($visibleErrors !== []): ?>
                    <ul class="alert-list mb-0 mt-2">
                        <?php foreach ($visibleErrors as $message): ?>
                            <li><?= esc($message) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($clients === [] || ($clientUser === null && $patients === [])): ?>
            <div class="alert alert-danger">No hay clientes o pacientes activos disponibles. Capture esos catálogos desde el panel administrativo antes de registrar una orden.</div>
        <?php elseif ($clientUser !== null && $patients === []): ?>
            <div class="alert alert-danger">Todavía no tienes pacientes registrados. Agrega uno desde el botón "+" para continuar.</div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('/orden-laboratorio') ?>" class="order-form">
            <?= csrf_field() ?>

            <div class="order-panel order-panel-primary">
                <div class="order-panel-head">
                    <h2>Datos generales</h2>
                    <p>La orden toma el folio automático del sistema y la fecha de recepción desde el registro.</p>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                        <label for="required_date" class="form-label">Fecha requerida</label>
                        <input id="required_date" name="required_date" class="form-control" type="date" value="<?= esc($formData['required_date']) ?>">
                        <?php if ($validation->hasError('required_date')): ?>
                            <p class="field-error"><?= esc($validation->getError('required_date')) ?></p>
                        <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($clientUser === null): ?>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="field">
                                <label for="client_id" class="form-label">Cliente / Dentista</label>
                                <select id="client_id" name="client_id" class="form-select" <?= $clients === [] ? 'disabled' : '' ?>>
                                    <option value="">Seleccione un cliente</option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= esc((string) $client['id']) ?>" data-phone="<?= esc($client['contact_phone'] ?? '') ?>" <?= (string) $formData['client_id'] === (string) $client['id'] ? 'selected' : '' ?>>
                                            <?= esc($client['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($validation->hasError('client_id')): ?>
                                    <p class="field-error"><?= esc($validation->getError('client_id')) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="client_id" name="client_id" value="<?= esc((string) $formData['client_id']) ?>" data-phone="<?= esc($clients[0]['contact_phone'] ?? '') ?>">
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="field">
                                <label class="form-label">Cliente / Dentista</label>
                                <input class="form-control" type="text" value="<?= esc($clientUser['name'] ?? '') ?>" readonly>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="patient_id" class="form-label">Paciente</label>
                            <div class="order-inline-field">
                                <select id="patient_id" name="patient_id" class="form-select" <?= $patients === [] ? 'disabled' : '' ?>>
                                    <option value="">Seleccione un paciente</option>
                                    <?php foreach ($patients as $patient): ?>
                                        <option value="<?= esc((string) $patient['id']) ?>" data-client-id="<?= esc((string) $patient['client_id']) ?>" <?= (string) $formData['patient_id'] === (string) $patient['id'] ? 'selected' : '' ?>>
                                            <?= esc($patient['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($clientUser !== null): ?>
                                    <button type="button" class="btn btn-outline btn-small order-plus-button" data-bs-toggle="modal" data-bs-target="#patientModal" aria-label="Agregar paciente">+</button>
                                <?php endif; ?>
                            </div>
                            <?php if ($validation->hasError('patient_id')): ?>
                                <p class="field-error"><?= esc($validation->getError('patient_id')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="client_phone_display" class="form-label">Teléfono de contacto</label>
                            <input id="client_phone_display" class="form-control" type="text" value="<?= esc($clients[0]['contact_phone'] ?? '') ?>" readonly>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="field">
                            <label for="shade" class="form-label">Color</label>
                            <input id="shade" name="shade" class="form-control" type="text" value="<?= esc($formData['shade']) ?>" placeholder="Ej. A2, B1, Bleach">
                            <?php if ($validation->hasError('shade')): ?>
                                <p class="field-error"><?= esc($validation->getError('shade')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-6 d-flex">
                    <div class="order-panel w-100 h-100">
                    <div class="order-panel-head">
                        <h2>Trabajo a realizar</h2>
                        <p>Seleccione uno o más trabajos del formato original.</p>
                    </div>

                    <div class="row g-3">
                        <?php foreach ($workTypes as $workType): ?>
                            <div class="col-12 col-md-6 check-option">
                                <label class="check-tile">
                                    <input type="checkbox" name="work_types[]" value="<?= esc($workType) ?>" <?= in_array($workType, $formData['work_types'], true) ? 'checked' : '' ?>>
                                    <span><?= esc($workType) ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($validation->hasError('work_types')): ?>
                        <p class="field-error"><?= esc($validation->getError('work_types')) ?></p>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-xl-6 d-flex">
                    <div class="order-panel w-100 h-100">
                    <div class="order-panel-head">
                        <h2>Restauración e implante</h2>
                        <p>Tipo de restauración y configuración de prótesis sobre implante.</p>
                    </div>

                    <div class="stack-block">
                        <p class="block-label">Restauración</p>
                        <div class="row g-3">
                            <?php foreach ($restorationTypes as $restorationType): ?>
                                <div class="col-12 col-md-6 check-option">
                                    <label class="check-tile">
                                        <input type="checkbox" name="restoration_types[]" value="<?= esc($restorationType) ?>" <?= in_array($restorationType, $formData['restoration_types'], true) ? 'checked' : '' ?>>
                                        <span><?= esc($restorationType) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="implant-box">
                        <label class="inline-check">
                            <input type="checkbox" name="implant_case" value="1" <?= $formData['implant_case'] ? 'checked' : '' ?>>
                            <span>Prótesis sobre implante</span>
                        </label>

                        <div class="row g-3">
                            <?php foreach ($implantOptions as $implantValue => $implantLabel): ?>
                                <div class="col-12 col-md-6 check-option">
                                    <label class="check-tile">
                                        <input type="radio" name="implant_chimney" value="<?= esc($implantValue) ?>" <?= $formData['implant_chimney'] === $implantValue ? 'checked' : '' ?>>
                                        <span><?= esc($implantLabel) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($validation->hasError('implant_chimney')): ?>
                            <p class="field-error"><?= esc($validation->getError('implant_chimney')) ?></p>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>

            <div class="order-panel order-panel-teeth">
                <div class="order-panel-head">
                    <h2>Selección de dientes</h2>
                    <p>Capture las piezas dentales del caso usando el esquema FDI estándar de laboratorio.</p>
                </div>

                <?php
                    $upperLeft = array_slice($upperTeeth, 0, 8);
                    $upperRight = array_slice($upperTeeth, 8);
                    $lowerLeft = array_slice($lowerTeeth, 0, 8);
                    $lowerRight = array_slice($lowerTeeth, 8);
                ?>
                <div class="teeth-card">
                    <div class="teeth-meta">
                        <span class="teeth-badge">FDI</span>
                        <span><strong data-selected-teeth-count><?= count($formData['selected_teeth']) ?></strong> diente(s) seleccionado(s)</span>
                    </div>

                    <div class="teeth-chart-wrap">
                        <div class="teeth-chart" role="group" aria-label="Selección de dientes FDI">
                            <div class="teeth-quadrant teeth-quadrant-left">
                                <?php foreach ($upperLeft as $tooth): ?>
                                    <label class="tooth-box">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-right">
                                <?php foreach ($upperRight as $tooth): ?>
                                    <label class="tooth-box">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-left teeth-quadrant-lower">
                                <?php foreach ($lowerLeft as $tooth): ?>
                                    <label class="tooth-box tooth-box-lower">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-right teeth-quadrant-lower">
                                <?php foreach ($lowerRight as $tooth): ?>
                                    <label class="tooth-box tooth-box-lower">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $formData['selected_teeth'], true) ? 'checked' : '' ?>>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($validation->hasError('selected_teeth')): ?>
                    <p class="field-error"><?= esc($validation->getError('selected_teeth')) ?></p>
                <?php endif; ?>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-12 col-xl-8">
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
                    </div>
                </div>

                <aside class="col-12 col-xl-4">
                    <div class="order-submit-card">
                    <h3>Guardar orden</h3>
                    <p>El formulario se valida en servidor y queda listo para persistirse en MySQL desde `CI4`.</p>
                    <button type="submit" class="btn btn-secondary order-submit">Guardar orden</button>
                    <a href="<?= site_url('/orden-laboratorio') ?>" class="btn btn-outline order-submit">Limpiar formulario</a>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</section>
<?php if ($clientUser !== null): ?>
<div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="patientModalLabel">Agregar paciente</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="quick-patient-form" method="post" action="<?= site_url('/orden-laboratorio/paciente') ?>" class="stack-form">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label for="quick_patient_name" class="form-label">Nombre del paciente</label>
                        <input id="quick_patient_name" name="name" class="form-control" type="text" required>
                    </div>
                    <div class="field">
                        <label for="quick_patient_notes" class="form-label">Notas</label>
                        <textarea id="quick_patient_notes" name="notes" class="form-control" rows="4"></textarea>
                    </div>
                    <p class="field-error" id="quick-patient-error" hidden></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const clientSelect = document.getElementById('client_id');
    const patientSelect = document.getElementById('patient_id');
    const phoneDisplay = document.getElementById('client_phone_display');
    const selectedTeethCount = document.querySelector('[data-selected-teeth-count]');
    const quickPatientForm = document.getElementById('quick-patient-form');
    const quickPatientError = document.getElementById('quick-patient-error');
    const patientModalElement = document.getElementById('patientModal');
    const patientModal = patientModalElement ? bootstrap.Modal.getOrCreateInstance(patientModalElement) : null;

    if (!clientSelect || !patientSelect || !phoneDisplay) {
        return;
    }

        const hasClientSelect = clientSelect.tagName === 'SELECT';

        const filterPatients = function () {
            const selectedClientId = clientSelect.value;
            const currentPatientId = patientSelect.value;
            let currentStillVisible = false;

        Array.from(patientSelect.options).forEach(function (option, index) {
            if (index === 0) {
                option.hidden = false;
                return;
            }

            const matchesClient = selectedClientId !== '' && option.dataset.clientId === selectedClientId;
            option.hidden = !matchesClient;

            if (matchesClient && option.value === currentPatientId) {
                currentStillVisible = true;
            }
        });

        if (!currentStillVisible) {
            patientSelect.value = '';
        }

        patientSelect.disabled = selectedClientId === '';
    };

        const syncPhone = function () {
            if (hasClientSelect) {
                const option = clientSelect.options[clientSelect.selectedIndex];
                phoneDisplay.value = option ? option.dataset.phone || '' : '';
                return;
            }

            phoneDisplay.value = clientSelect.dataset.phone || '';
        };

    if (hasClientSelect) {
        clientSelect.addEventListener('change', function () {
            filterPatients();
            syncPhone();
        });
    }

    document.querySelectorAll('.tooth-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (!selectedTeethCount) {
                return;
            }

            selectedTeethCount.textContent = String(document.querySelectorAll('.tooth-checkbox:checked').length);
        });
    });

    if (quickPatientForm && quickPatientError) {
        quickPatientForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            quickPatientError.hidden = true;
            quickPatientError.textContent = '';

            const formData = new FormData(quickPatientForm);

            try {
                const response = await fetch(quickPatientForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const payload = await response.json();

                quickPatientForm.querySelectorAll('input[name="<?= csrf_token() ?>"]').forEach(function (input) {
                    input.value = payload.csrf || input.value;
                });
                document.querySelectorAll('input[name="<?= csrf_token() ?>"]').forEach(function (input) {
                    input.value = payload.csrf || input.value;
                });

                if (!response.ok || !payload.patient) {
                    quickPatientError.textContent = payload.message || 'No fue posible crear el paciente.';
                    quickPatientError.hidden = false;
                    return;
                }

                const option = document.createElement('option');
                option.value = String(payload.patient.id);
                option.dataset.clientId = String(payload.patient.client_id);
                option.textContent = payload.patient.name;
                option.selected = true;
                patientSelect.appendChild(option);
                patientSelect.disabled = false;
                patientSelect.value = String(payload.patient.id);

                filterPatients();
                quickPatientForm.reset();
                patientModal?.hide();
            } catch (error) {
                quickPatientError.textContent = 'No fue posible crear el paciente.';
                quickPatientError.hidden = false;
            }
        });
    }

    filterPatients();
    syncPhone();
});
</script>
<?= $this->endSection() ?>
