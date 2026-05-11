<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center ">
        <h1>Aviso de Privacidad</h1>
        <p>Tratamiento de datos personales recabados a través del sitio, formularios de contacto, registro de clientes y órdenes de laboratorio.</p>
    </div>
</section>

<section class="section" style="padding: 2rem 0 2rem 0;">
    <div class="container">
        <article class="mini-card">
            <p><strong>Última actualización:</strong> <?= date('d/m/Y') ?></p>

            <h2>1. Identidad y domicilio del responsable</h2>
            <p>POT Prótesis Dental, con domicilio en <?= esc(site_setting('contact_address', 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.')) ?>, es responsable del tratamiento de los datos personales que recaba a través de este sitio web y de los medios relacionados con la prestación de sus servicios.</p>
            <p>Para cualquier asunto relacionado con privacidad y protección de datos personales, puede escribir a <a href="mailto:<?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?>"><?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?></a> o comunicarse al teléfono <a href="tel:<?= esc(site_setting('contact_phone_href', '+523334735108')) ?>"><?= esc(site_setting('contact_phone', '(33) 3473-5108')) ?></a>.</p>

            <h2>2. Marco normativo aplicable</h2>
            <p>El presente aviso de privacidad se emite en cumplimiento de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, su Reglamento y demás disposiciones aplicables en los Estados Unidos Mexicanos.</p>

            <h2>3. Datos personales que podemos recabar</h2>
            <p>Dependiendo del formulario, servicio o interacción que utilice dentro del sitio, POT Prótesis Dental podrá recabar las siguientes categorías de datos personales:</p>
            <ul>
                <li>Datos de identificación y contacto, como nombre, nombre de clínica o consultorio, correo electrónico, teléfono y datos de contacto comercial.</li>
                <li>Datos de acceso y autenticación, como contraseña cifrada, token de activación y datos básicos de sesión para clientes registrados.</li>
                <li>Datos operativos de servicio, como información de órdenes de laboratorio, fechas requeridas, tipo de trabajo, restauraciones, piezas dentales, observaciones, archivos adjuntos y datos de seguimiento del caso.</li>
                <li>Datos de pacientes capturados por clientes o usuarios autorizados, como nombre del paciente y notas asociadas al caso clínico.</li>
                <li>Datos técnicos de navegación y seguridad, como dirección IP, agente de usuario, registros de actividad, tokens de seguridad, información de sesión y datos necesarios para prevenir abuso del sitio.</li>
            </ul>
            <p>Si en las observaciones, archivos adjuntos o documentación de una orden se incluyen datos de salud, antecedentes clínicos, imágenes, escaneos, referencias odontológicas u otra información relacionada con el estado de salud de una persona, dicha información podrá ser considerada <strong>dato personal sensible</strong> conforme a la legislación aplicable.</p>

            <h2>4. Finalidades primarias del tratamiento</h2>
            <p>Sus datos personales serán tratados para las siguientes finalidades necesarias para la relación comercial o de servicio:</p>
            <ul>
                <li>Atender solicitudes de información, contacto, cotización o seguimiento recibidas por medio del formulario de contacto, correo electrónico, teléfono o WhatsApp.</li>
                <li>Registrar, administrar y autenticar cuentas de clientes dentro del sitio.</li>
                <li>Verificar la titularidad o control de una cuenta mediante mecanismos de activación por correo electrónico.</li>
                <li>Recibir, integrar, gestionar, fabricar, actualizar y dar seguimiento a órdenes de laboratorio y casos protésicos.</li>
                <li>Administrar catálogos de clientes, pacientes, servicios, archivos y comunicaciones vinculadas con la prestación del servicio.</li>
                <li>Enviar notificaciones operativas relacionadas con la cuenta, activación de acceso, recepción de órdenes, estatus del servicio y atención al cliente.</li>
                <li>Conservar evidencia operativa, administrativa y de seguridad para la defensa de derechos, cumplimiento de obligaciones y atención de requerimientos legales.</li>
                <li>Prevenir fraude, accesos no autorizados, spam, abuso de formularios y otros incidentes de seguridad.</li>
            </ul>

            <h2>5. Finalidades secundarias</h2>
            <p>Salvo que se informe expresamente lo contrario en un mecanismo específico, POT Prótesis Dental no utiliza sus datos personales para campañas publicitarias masivas ajenas a la relación comercial solicitada. En caso de que en el futuro se pretendan tratar sus datos para finalidades secundarias distintas a las aquí señaladas, se le informará por los medios correspondientes cuando ello sea legalmente exigible.</p>

            <h2>6. Consentimiento y responsabilidad sobre datos de terceros</h2>
            <p>Al proporcionar datos personales a través del sitio, usted manifiesta que actúa con información propia o con facultades suficientes para compartir los datos que incorpora en formularios, órdenes o archivos. Cuando se capturen datos de pacientes o terceros, el usuario que los proporcione será responsable de contar con la autorización, instrucción o base jurídica necesaria para ello.</p>
            <p>En el caso de datos personales sensibles, su entrega voluntaria a través de órdenes, observaciones o archivos adjuntos se entenderá como consentimiento expreso para su tratamiento en la medida necesaria para prestar el servicio solicitado, salvo las excepciones previstas por la ley.</p>

            <h2>7. Transferencias de datos personales</h2>
            <p>POT Prótesis Dental no venderá ni cederá sus datos personales a terceros para fines comerciales no autorizados. No obstante, sus datos podrán ser compartidos cuando resulte necesario en los siguientes supuestos:</p>
            <ul>
                <li>Con proveedores que apoyen en servicios tecnológicos, alojamiento, correo electrónico, soporte o continuidad operativa, bajo obligaciones de confidencialidad y seguridad.</li>
                <li>Con clientes, personal autorizado, laboratorios, técnicos o responsables vinculados al caso, cuando ello sea necesario para la gestión y ejecución de la orden o servicio solicitado.</li>
                <li>Con autoridades competentes, cuando exista requerimiento fundado y motivado o cuando la legislación aplicable así lo permita o exija.</li>
            </ul>

            <h2>8. Medios para limitar el uso o divulgación de sus datos</h2>
            <p>Usted puede solicitar en cualquier momento la limitación del uso o divulgación de sus datos personales para determinados tratamientos no indispensables, enviando su solicitud a <a href="mailto:<?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?>"><?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?></a>. POT Prótesis Dental analizará la procedencia de su petición conforme a la legislación aplicable y a la naturaleza de la relación jurídica existente.</p>

            <h2>9. Derechos ARCO y revocación del consentimiento</h2>
            <p>Usted o su representante legal puede ejercer los derechos de acceso, rectificación, cancelación y oposición respecto de sus datos personales, así como revocar el consentimiento que haya otorgado para su tratamiento, en la medida en que ello sea procedente y no exista una excepción legal u obligación de conservación.</p>
            <p>Para ejercer estos derechos deberá enviar una solicitud al correo <a href="mailto:<?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?>"><?= esc(site_setting('contact_email', 'contacto@potprotesisdental.com')) ?></a> indicando, al menos:</p>
            <ul>
                <li>Nombre completo del titular y medios de contacto para comunicar la respuesta.</li>
                <li>Documentos o información que permitan acreditar su identidad o, en su caso, la representación legal.</li>
                <li>Descripción clara de los datos respecto de los cuales desea ejercer algún derecho ARCO.</li>
                <li>La petición concreta que formula y, cuando resulte aplicable, la documentación que sustente la rectificación o aclaración solicitada.</li>
            </ul>
            <p>La respuesta se emitirá dentro de un plazo razonable conforme a la legislación aplicable y podrá requerirse información adicional para validar identidad, alcance de la solicitud o procedencia legal.</p>

            <h2>10. Uso de cookies y tecnologías similares</h2>
            <p>El sitio puede utilizar cookies, sesiones y tecnologías técnicas similares necesarias para su funcionamiento, seguridad, autenticación, prevención de fraude y conservación de preferencias básicas. Estas tecnologías no se usan por sí mismas para fines publicitarios invasivos desde este aviso, sin perjuicio de herramientas de terceros estrictamente necesarias para la operación del sitio.</p>

            <h2>11. Medidas de seguridad y conservación</h2>
            <p>POT Prótesis Dental adopta medidas administrativas, técnicas y físicas razonables para proteger los datos personales contra daño, pérdida, alteración, destrucción o uso, acceso o tratamiento no autorizado. Los datos serán conservados durante el tiempo necesario para cumplir las finalidades descritas, atender obligaciones legales, contractuales, fiscales, sanitarias, administrativas, de trazabilidad, seguridad y defensa jurídica, y posteriormente serán suprimidos o bloqueados cuando proceda.</p>

            <h2>12. Cambios al aviso de privacidad</h2>
            <p>POT Prótesis Dental podrá modificar o actualizar el presente aviso de privacidad cuando resulte necesario por cambios normativos, operativos o de servicio. Cualquier cambio sustancial se pondrá a disposición a través de esta misma sección del sitio web: <a href="<?= base_url('privacidad') ?>"><?= base_url('privacidad') ?></a>.</p>

            <h2>13. Autoridad competente</h2>
            <p>Si considera que su derecho a la protección de datos personales ha sido vulnerado, puede acudir ante la autoridad competente en México, incluyendo el Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales (INAI), conforme a los mecanismos previstos en la legislación aplicable.</p>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
