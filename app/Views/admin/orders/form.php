<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
    $fullEditDisabled = ! $isFullEditUnlocked;
    $fullEditAttr = $fullEditDisabled ? 'disabled' : '';
    $statusOnlyMode = $fullEditDisabled;
?>
<section class="section">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg">
                <span class="eyebrow eyebrow-aqua">Panel Admin</span>
                <h1>Editar orden</h1>
                <p>
                    <?php if ($isFullEditUnlocked): ?>
                        Edición completa autorizada para esta orden. Recuerde guardar los cambios para cerrar la sesión de edición.
                    <?php elseif ($canUnlockFullEdit): ?>
                        El estatus se puede actualizar directamente. Para modificar el resto de los datos primero autorice la edición completa.
                    <?php else: ?>
                        Puede actualizar el estatus de la orden. El resto de la información está bloqueada para su rol.
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-12 col-lg-auto">
                <a href="<?= base_url('admin/ordenes') ?>" class="btn btn-outline">Volver</a>
            </div>
        </div>

        <?php if ($validation->getErrors() !== []): ?>
            <div class="alert alert-danger">Revise los campos marcados antes de guardar la orden.</div>
        <?php endif; ?>

        <?php if ($clients === [] || $patients === []): ?>
            <div class="alert alert-danger">Faltan clientes o pacientes activos en catálogo. Complete esos datos antes de actualizar la orden.</div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/ordenes/actualizar/' . $order['id']) ?>" class="order-form" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="order-panel">
                <div class="order-panel-head">
                    <h2>Archivos del caso</h2>
                    <p>Opcional. Adjunte hasta 5 archivos en formato STL, OTL o PDF.</p>
                </div>

                <div class="field">
                    <label for="attachments" class="form-label">Archivos adjuntos</label>
                    <input id="attachments" name="attachments[]" class="form-control" type="file" accept=".stl,.otl,.pdf,application/pdf" multiple <?= $fullEditAttr ?>>
                    <p class="field-help">Máximo 5 archivos por orden. Los nuevos se agregan a los ya existentes.</p>
                    <?php if ($validation->hasError('attachments')): ?>
                        <p class="field-error"><?= esc($validation->getError('attachments')) ?></p>
                    <?php endif; ?>
                </div>

                <?php if (($order['attachments'] ?? []) !== []): ?>
                    <div class="field mt-3">
                        <label class="form-label">Archivos actuales</label>
                        <ul class="file-list">
                            <?php foreach ($order['attachments'] as $index => $attachment): ?>
                                <li>
                                    <a href="<?= base_url('admin/ordenes/archivo/' . $order['id'] . '/' . $index) ?>" target="_blank" rel="noopener noreferrer">
                                        <?= esc($attachment['original_name'] ?? $attachment['stored_name'] ?? 'Archivo') ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="order-panel order-panel-teeth">
                <div class="order-panel-head">
                    <h2>Datos generales</h2>
                    <p>Orden #<?= esc($order['order_number'] !== '' ? $order['order_number'] : $order['id']) ?> registrada el <?= esc(site_datetime($order['created_at'] ?? null)) ?></p>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="required_date" class="form-label">Fecha requerida</label>
                            <input id="required_date" name="required_date" class="form-control" type="date" min="<?= esc($minRequiredDate) ?>" value="<?= esc($order['required_date']) ?>" <?= $fullEditAttr ?>>
                            <?php if ($validation->hasError('required_date')): ?>
                                <p class="field-error"><?= esc($validation->getError('required_date')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="client_id" class="form-label">Cliente / Dentista</label>
                            <select id="client_id" name="client_id" class="form-select" <?= $fullEditAttr ?>>
                                <option value="">Seleccione un cliente</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= esc((string) $client['id']) ?>" data-phone="<?= esc($client['contact_phone'] ?? '') ?>" <?= (string) $order['client_id'] === (string) $client['id'] ? 'selected' : '' ?>>
                                        <?= esc($client['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($validation->hasError('client_id')): ?>
                                <p class="field-error"><?= esc($validation->getError('client_id')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="patient_id" class="form-label">Paciente</label>
                            <select id="patient_id" name="patient_id" class="form-select" <?= $fullEditAttr ?>>
                                <option value="">Seleccione un paciente</option>
                                <?php foreach ($patients as $patient): ?>
                                    <option value="<?= esc((string) $patient['id']) ?>" data-client-id="<?= esc((string) $patient['client_id']) ?>" <?= (string) $order['patient_id'] === (string) $patient['id'] ? 'selected' : '' ?>>
                                        <?= esc($patient['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($validation->hasError('patient_id')): ?>
                                <p class="field-error"><?= esc($validation->getError('patient_id')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="client_phone_display" class="form-label">Teléfono de contacto</label>
                            <input id="client_phone_display" class="form-control" type="text" value="<?= esc($order['contact_phone']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="field">
                            <label for="status" class="form-label">Estatus</label>
                            <select id="status" name="status" class="form-select">
                                <?php foreach (pot_order_status_options() as $statusValue => $statusLabel): ?>
                                    <option value="<?= esc($statusValue) ?>" <?= ($order['status'] ?? 'recibida') === $statusValue ? 'selected' : '' ?>>
                                        <?= esc($statusLabel) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($validation->hasError('status')): ?>
                                <p class="field-error"><?= esc($validation->getError('status')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label for="shade" class="form-label">Color</label>
                            <input id="shade" name="shade" class="form-control" type="text" value="<?= esc($order['shade']) ?>" <?= $fullEditAttr ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-6 d-flex">
                    <div class="order-panel w-100 h-100">
                        <div class="order-panel-head">
                            <h2>Trabajo a realizar</h2>
                        </div>
                        <div class="row g-3">
                            <?php foreach ($workTypes as $workType): ?>
                                <div class="col-12 col-md-6 check-option">
                                    <label class="check-tile">
                                        <input type="checkbox" name="work_types[]" value="<?= esc($workType) ?>" <?= in_array($workType, $order['work_types'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
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
                        </div>
                        <div class="stack-block">
                            <p class="block-label">Restauración</p>
                            <div class="row g-3">
                                <?php foreach ($restorationTypes as $restorationType): ?>
                                    <div class="col-12 col-md-6 check-option">
                                        <label class="check-tile">
                                            <input type="checkbox" name="restoration_types[]" value="<?= esc($restorationType) ?>" <?= in_array($restorationType, $order['restoration_types'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
                                            <span><?= esc($restorationType) ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="implant-box">
                            <label class="inline-check">
                                <input type="checkbox" name="implant_case" value="1" <?= $order['implant_case'] ? 'checked' : '' ?> <?= $fullEditAttr ?>>
                                <span>Prótesis sobre implante</span>
                            </label>

                            <div class="row g-3">
                                <?php foreach ($implantOptions as $implantValue => $implantLabel): ?>
                                    <div class="col-12 col-md-6 check-option">
                                        <label class="check-tile">
                                            <input type="radio" name="implant_chimney" value="<?= esc($implantValue) ?>" <?= $order['implant_chimney'] === $implantValue ? 'checked' : '' ?> <?= $fullEditAttr ?>>
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

            <div class="order-panel">
                <div class="order-panel-head">
                    <h2>Selección de dientes</h2>
                    <p>Capture las piezas dentales con el esquema FDI estándar de laboratorio.</p>
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
                        <span><strong data-selected-teeth-count><?= count($order['selected_teeth']) ?></strong> diente(s) seleccionado(s)</span>
                    </div>

                    <div class="teeth-chart-wrap">
                        <div class="teeth-chart" role="group" aria-label="Selección de dientes FDI">
                            <div class="teeth-quadrant teeth-quadrant-left">
                                <?php foreach ($upperLeft as $tooth): ?>
                                    <label class="tooth-box">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-right">
                                <?php foreach ($upperRight as $tooth): ?>
                                    <label class="tooth-box">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-left teeth-quadrant-lower">
                                <?php foreach ($lowerLeft as $tooth): ?>
                                    <label class="tooth-box tooth-box-lower">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
                                        <span class="tooth-square" aria-hidden="true"></span>
                                        <span class="tooth-number"><?= esc($tooth) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="teeth-quadrant teeth-quadrant-right teeth-quadrant-lower">
                                <?php foreach ($lowerRight as $tooth): ?>
                                    <label class="tooth-box tooth-box-lower">
                                        <input class="tooth-checkbox" type="checkbox" name="selected_teeth[]" value="<?= esc($tooth) ?>" <?= in_array($tooth, $order['selected_teeth'], true) ? 'checked' : '' ?> <?= $fullEditAttr ?>>
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
                        <div class="field">
                            <label for="observations" class="form-label">Observaciones</label>
                            <textarea id="observations" name="observations" class="form-control" rows="7" <?= $fullEditAttr ?>><?= esc($order['observations']) ?></textarea>
                        </div>
                    </div>
                </div>

                <aside class="col-12 col-xl-4">
                    <div class="order-submit-card">
                        <h3><?= $isFullEditUnlocked ? 'Guardar cambios' : 'Actualizar estatus' ?></h3>
                        <p>
                            <?php if ($isFullEditUnlocked): ?>
                                Los cambios se aplicarán directamente sobre la orden registrada.
                            <?php endif; ?>
                        </p>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-secondary order-submit">
                                <?= $isFullEditUnlocked ? 'Actualizar orden' : 'Guardar estatus' ?>
                            </button>
                            <?php if ($canUnlockFullEdit && ! $isFullEditUnlocked): ?>
                                <button type="button" class="btn btn-outline text-light" data-bs-toggle="modal" data-bs-target="#unlockOrderModal">
                                    Autorizar edición completa
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</section>

<?php if ($canUnlockFullEdit): ?>
    <div class="modal fade" id="unlockOrderModal" tabindex="-1" aria-labelledby="unlockOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="<?= base_url('admin/ordenes/desbloquear/' . $order['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="unlockOrderModalLabel">Autorizar edición completa</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Confirme su contraseña y documente el motivo antes de desbloquear la orden.</p>
                        <div class="field mb-3">
                            <label for="unlock_password" class="form-label">Contraseña del usuario admin</label>
                            <input id="unlock_password" name="unlock_password" class="form-control" type="password" required>
                            <?php if (($unlockErrors['unlock_password'] ?? '') !== ''): ?>
                                <p class="field-error"><?= esc($unlockErrors['unlock_password']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="field">
                            <label for="unlock_observations" class="form-label">Motivo de la edición</label>
                            <textarea id="unlock_observations" name="unlock_observations" class="form-control" rows="5" required><?= esc($unlockOld['unlock_observations'] ?? '') ?></textarea>
                            <?php if (($unlockErrors['unlock_observations'] ?? '') !== ''): ?>
                                <p class="field-error"><?= esc($unlockErrors['unlock_observations']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Validar y desbloquear</button>
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

    if (clientSelect && patientSelect && phoneDisplay) {
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

            if (!patientSelect.disabled) {
                patientSelect.disabled = selectedClientId === '';
            }
        };

        const syncPhone = function () {
            const option = clientSelect.options[clientSelect.selectedIndex];
            phoneDisplay.value = option ? option.dataset.phone || '' : '';
        };

        clientSelect.addEventListener('change', function () {
            filterPatients();
            syncPhone();
        });

        filterPatients();
        syncPhone();
    }

    document.querySelectorAll('.tooth-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (!selectedTeethCount) {
                return;
            }

            selectedTeethCount.textContent = String(document.querySelectorAll('.tooth-checkbox:checked').length);
        });
    });

    <?php if ($canUnlockFullEdit && $showUnlockModal): ?>
        const unlockModalElement = document.getElementById('unlockOrderModal');

        if (unlockModalElement && window.bootstrap) {
            window.bootstrap.Modal.getOrCreateInstance(unlockModalElement).show();
        }
    <?php endif; ?>
});
</script>
<?= $this->endSection() ?>
