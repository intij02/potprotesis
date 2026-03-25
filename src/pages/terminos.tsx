export default function TerminosPage() {
  return (
    <>
      <title>Términos y Condiciones - POT Prótesis Dental</title>
      <meta
        name="description"
        content="Términos y condiciones de uso de POT Prótesis Dental."
      />

      <main className="min-h-screen bg-background py-16">
        <section className="container mx-auto max-w-4xl px-4">
          <h1 className="text-4xl font-bold text-foreground mb-6">Términos y Condiciones</h1>
          <div className="space-y-6 text-muted-foreground leading-relaxed">
            <p>
              El contenido de este sitio es informativo y está dirigido a profesionales y clínicas dentales
              interesadas en servicios de laboratorio protésico.
            </p>
            <p>
              Los tiempos de entrega, costos y garantías pueden variar según el tipo de trabajo solicitado y se
              confirman en cada orden de servicio.
            </p>
            <p>
              El uso del sitio implica aceptación de estos términos. POT Prótesis Dental puede actualizarlos en
              cualquier momento sin previo aviso.
            </p>
            <p>
              Para aclaraciones comerciales o técnicas, contáctenos en{' '}
              <a className="text-primary underline" href="mailto:contacto@potprotesisdental.com">
                contacto@potprotesisdental.com
              </a>.
            </p>
          </div>
        </section>
      </main>
    </>
  );
}
