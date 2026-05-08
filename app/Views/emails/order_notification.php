<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva orden de laboratorio</title>
</head>
<body style="margin:0;padding:24px;background:#f4f6fb;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:720px;border-collapse:collapse;background:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #dbe3ef;">
                    <tr>
                        <td style="padding:32px 36px;background:#3a4154;color:#ffffff;">
                            <div style="font-size:13px;letter-spacing:0.08em;text-transform:uppercase;opacity:0.82;">POT Prótesis Dental</div>
                            <h1 style="margin:12px 0 0;font-size:28px;line-height:1.15;font-weight:700;">Nueva orden de laboratorio</h1>
                            <p style="margin:12px 0 0;font-size:15px;line-height:1.6;opacity:0.92;">Se registró una nueva orden enviada por cliente/dentista.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 36px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-bottom:24px;">
                                <tr>
                                    <td style="width:50%;padding:0 12px 12px 0;vertical-align:top;">
                                        <div style="padding:18px;border:1px solid #dbe3ef;border-radius:16px;background:#f9fbff;">
                                            <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.06em;color:#6b7280;">Orden</div>
                                            <div style="margin-top:8px;font-size:22px;font-weight:700;color:#1f2937;">#<?= esc((string) $orderId) ?></div>
                                        </div>
                                    </td>
                                    <td style="width:50%;padding:0 0 12px 12px;vertical-align:top;">
                                        <div style="padding:18px;border:1px solid #dbe3ef;border-radius:16px;background:#f9fbff;">
                                            <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.06em;color:#6b7280;">Fecha requerida</div>
                                            <div style="margin-top:8px;font-size:22px;font-weight:700;color:#1f2937;"><?= esc($requiredDate) ?></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;width:32%;">Dentista</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($dentistName) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Paciente</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($patientName) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Teléfono</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($contactPhone) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Color</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($shade) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Trabajo(s)</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($workTypes) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Diente(s)</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($selectedTeeth) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Restauración(es)</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($restorationTypes) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Implante</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc($implantLabel) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;">Adjuntos</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;color:#111827;"><?= esc((string) $attachmentsCount) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;background:#f9fafb;font-size:13px;font-weight:700;color:#374151;vertical-align:top;">Observaciones</td>
                                    <td style="padding:14px 18px;background:#ffffff;font-size:14px;line-height:1.7;color:#111827;white-space:pre-line;"><?= esc($observations) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
