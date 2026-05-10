<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de estatus</title>
</head>
<body style="margin:0;padding:24px;background:#f3f6fb;font-family:Arial,Helvetica,sans-serif;color:#17324d;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;border-collapse:collapse;background:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #d8e2ef;">
                    <tr>
                        <td style="padding:32px 36px;background:linear-gradient(135deg,#123c69 0%,#1f6aa5 100%);color:#ffffff;">
                            <p style="margin:0 0 10px;font-size:13px;letter-spacing:.08em;text-transform:uppercase;opacity:.8;">POT Prótesis Dental</p>
                            <h1 style="margin:0;font-size:28px;line-height:1.2;">Tu orden cambió de estatus</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 36px;">
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">Hola <?= esc($clientName) ?>,</p>
                            <p style="margin:0 0 24px;font-size:16px;line-height:1.7;">Te informamos que la orden <strong><?= esc($orderNumber) ?></strong> fue actualizada en el panel de laboratorio.</p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin:0 0 24px;background:#f8fbff;border:1px solid #d7e7f6;border-radius:16px;">
                                <tr>
                                    <td style="padding:24px;">
                                        <p style="margin:0 0 10px;font-size:14px;color:#53708e;">Paciente</p>
                                        <p style="margin:0 0 18px;font-size:18px;font-weight:700;color:#17324d;"><?= esc($patientName !== '' ? $patientName : 'No especificado') ?></p>
                                        <p style="margin:0 0 10px;font-size:14px;color:#53708e;">Estatus anterior</p>
                                        <p style="margin:0 0 18px;font-size:18px;font-weight:700;color:#7b8da1;"><?= esc($previousStatus) ?></p>
                                        <p style="margin:0 0 10px;font-size:14px;color:#53708e;">Nuevo estatus</p>
                                        <p style="margin:0;font-size:22px;font-weight:700;color:#0d5f9a;"><?= esc($newStatus) ?></p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;font-size:15px;line-height:1.7;">Si tienes dudas sobre la entrega o el seguimiento del caso, puedes responder por los canales habituales de contacto.</p>
                            <p style="margin:0;font-size:15px;line-height:1.7;">
                                Teléfono: <strong><?= esc($contactPhone !== '' ? $contactPhone : 'No disponible') ?></strong><br>
                                Email: <strong><?= esc($contactEmail) ?></strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
