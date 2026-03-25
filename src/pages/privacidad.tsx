export default function PrivacidadPage() {
  return (
    <>
      <title>Aviso de Privacidad - POT Prótesis Dental</title>
      <meta
        name="description"
        content="Aviso de privacidad de POT Prótesis Dental sobre el tratamiento de datos personales."
      />

      <main className="min-h-screen bg-background py-16">
        <section className="container mx-auto max-w-4xl px-4">
          <h1 className="text-4xl font-bold text-foreground mb-6">Aviso de Privacidad</h1>
          <div className="space-y-6 text-muted-foreground leading-relaxed">
            <p>
              En POT Prótesis Dental tratamos sus datos personales con responsabilidad y en apego a la
              normativa aplicable en México.
            </p>
            <p>
              Los datos recabados mediante formularios de contacto, teléfono o correo se usan para atender
              solicitudes, dar seguimiento comercial y coordinar servicios de laboratorio dental.
            </p>
            <p>
              Usted puede solicitar el acceso, rectificación, cancelación u oposición de sus datos (derechos
              ARCO) escribiendo a <a className="text-primary underline" href="mailto:contacto@potprotesisdental.com">contacto@potprotesisdental.com</a>.
            </p>
            <p>
              Este aviso puede actualizarse. Recomendamos revisar esta página periódicamente para conocer la
              versión vigente.
            </p>
          </div>
        </section>
      </main>
    </>
  );
}
