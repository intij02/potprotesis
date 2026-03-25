import { motion } from 'motion/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { 
  CheckCircle2, 
  Phone, 
  Clock,
  Award,
  Microscope,
  Shield,
  Sparkles,
  ArrowRight
} from 'lucide-react';

/**
 * Servicios Page - POT Prótesis Dental
 * Detailed services information page
 */
export default function ServiciosPage() {
  const fadeInUp = {
    hidden: { opacity: 0, y: 20 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.5, ease: 'easeOut' as const } }
  } as const;

  const staggerContainer = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        staggerChildren: 0.15
      }
    }
  } as const;

  return (
    <>
      <title>Servicios - POT Prótesis Dental</title>
      <meta name="description" content="Servicios profesionales de prótesis dental: coronas, puentes, prótesis removibles e implantes. Calidad garantizada para dentistas en Guadalajara." />

      <div className="min-h-screen">
        {/* Hero Section */}
        <section className="relative py-20 bg-gradient-to-br from-primary/5 via-background to-accent/5">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              animate="visible"
              variants={staggerContainer}
              className="max-w-4xl mx-auto text-center"
            >
              <motion.div variants={fadeInUp} className="mb-6">
                <Badge className="mb-4">Servicios Profesionales</Badge>
                <h1 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
                  Soluciones Completas en Prótesis Dental
                </h1>
                <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                  Ofrecemos una amplia gama de servicios especializados con los más altos estándares de calidad y precisión técnica
                </p>
              </motion.div>

              <motion.div 
                variants={fadeInUp}
                className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12"
              >
                <Card>
                  <CardContent className="p-6 text-center">
                    <Award className="w-10 h-10 text-primary mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">Calidad Certificada</h3>
                    <p className="text-sm text-muted-foreground">Materiales premium</p>
                  </CardContent>
                </Card>
                <Card>
                  <CardContent className="p-6 text-center">
                    <Clock className="w-10 h-10 text-primary mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">Entrega Rápida</h3>
                    <p className="text-sm text-muted-foreground">Tiempos optimizados</p>
                  </CardContent>
                </Card>
                <Card>
                  <CardContent className="p-6 text-center">
                    <Microscope className="w-10 h-10 text-primary mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">Precisión Técnica</h3>
                    <p className="text-sm text-muted-foreground">Tecnología avanzada</p>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Service 1 - Coronas y Puentes */}
        <section className="py-20 bg-background">
          <div className="container mx-auto px-4">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={fadeInUp}
              >
                <div className="aspect-[4/3] rounded-lg overflow-hidden">
                  <img 
                    src="/media/pages-home-gallery-3-e1a8d6f3.jpg"
                    alt="Coronas y puentes dentales"
                    className="w-full h-full object-cover"
                  />
                </div>
              </motion.div>

              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={staggerContainer}
              >
                <motion.div variants={fadeInUp}>
                  <Badge className="mb-4">Restauraciones Fijas</Badge>
                  <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-6">
                    Coronas y Puentes
                  </h2>
                  <p className="text-lg text-muted-foreground mb-6">
                    Restauraciones protésicas fijas de alta precisión que devuelven funcionalidad y estética natural a la sonrisa de sus pacientes.
                  </p>
                </motion.div>

                <motion.div variants={fadeInUp} className="space-y-4 mb-8">
                  <h3 className="font-semibold text-foreground text-lg">Tipos de Coronas:</h3>
                  <div className="space-y-3">
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Coronas de Porcelana</p>
                        <p className="text-sm text-muted-foreground">Estética superior para sector anterior</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Coronas de Zirconia</p>
                        <p className="text-sm text-muted-foreground">Máxima resistencia y biocompatibilidad</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Metal-Porcelana</p>
                        <p className="text-sm text-muted-foreground">Durabilidad comprobada para molares</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Puentes Fijos</p>
                        <p className="text-sm text-muted-foreground">Restauración de múltiples piezas dentales</p>
                      </div>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp} className="bg-muted/30 rounded-lg p-6 mb-6">
                  <div className="flex items-start gap-3">
                    <Shield className="w-6 h-6 text-primary flex-shrink-0 mt-1" />
                    <div>
                      <h4 className="font-semibold mb-2">Garantía de Calidad</h4>
                      <p className="text-sm text-muted-foreground">
                        Todos nuestros trabajos cuentan con garantía. Utilizamos únicamente materiales certificados de las mejores marcas internacionales.
                      </p>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp}>
                  <Button size="lg">
                    <Phone className="w-5 h-5 mr-2" />
                    Solicitar Información
                  </Button>
                </motion.div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Service 2 - Prótesis Removibles */}
        <section className="py-20 bg-muted/20">
          <div className="container mx-auto px-4">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={staggerContainer}
                className="order-2 lg:order-1"
              >
                <motion.div variants={fadeInUp}>
                  <Badge className="mb-4">Soluciones Removibles</Badge>
                  <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-6">
                    Prótesis Removibles
                  </h2>
                  <p className="text-lg text-muted-foreground mb-6">
                    Dentaduras parciales y completas diseñadas con precisión anatómica para máxima comodidad y funcionalidad.
                  </p>
                </motion.div>

                <motion.div variants={fadeInUp} className="space-y-4 mb-8">
                  <h3 className="font-semibold text-foreground text-lg">Opciones Disponibles:</h3>
                  <div className="space-y-3">
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Prótesis Parciales</p>
                        <p className="text-sm text-muted-foreground">Con ganchos metálicos o estéticos</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Prótesis Totales</p>
                        <p className="text-sm text-muted-foreground">Dentaduras completas superiores e inferiores</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Prótesis Flexibles</p>
                        <p className="text-sm text-muted-foreground">Mayor comodidad sin ganchos metálicos</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Prótesis Inmediatas</p>
                        <p className="text-sm text-muted-foreground">Colocación inmediata post-extracción</p>
                      </div>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp} className="bg-background rounded-lg p-6 mb-6 border border-border">
                  <div className="flex items-start gap-3">
                    <Sparkles className="w-6 h-6 text-primary flex-shrink-0 mt-1" />
                    <div>
                      <h4 className="font-semibold mb-2">Diseño Personalizado</h4>
                      <p className="text-sm text-muted-foreground">
                        Cada prótesis es diseñada individualmente considerando la anatomía, oclusión y preferencias estéticas del paciente.
                      </p>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp}>
                  <Button size="lg">
                    <Phone className="w-5 h-5 mr-2" />
                    Solicitar Cotización
                  </Button>
                </motion.div>
              </motion.div>

              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={fadeInUp}
                className="order-1 lg:order-2"
              >
                <div className="aspect-[4/3] rounded-lg overflow-hidden">
                  <img 
                    src="/media/pages-home-gallery-3-94a5fe60.jpg"
                    alt="Prótesis removibles"
                    className="w-full h-full object-cover"
                  />
                </div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Service 3 - Implantes */}
        <section className="py-20 bg-background">
          <div className="container mx-auto px-4">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={fadeInUp}
              >
                <div className="aspect-[4/3] rounded-lg overflow-hidden">
                  <img 
                    src="/media/pages-home-gallery-3-e1a8d6f3.jpg"
                    alt="Prótesis sobre implantes"
                    className="w-full h-full object-cover"
                  />
                </div>
              </motion.div>

              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={staggerContainer}
              >
                <motion.div variants={fadeInUp}>
                  <Badge className="mb-4">Tecnología Avanzada</Badge>
                  <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-6">
                    Prótesis sobre Implantes
                  </h2>
                  <p className="text-lg text-muted-foreground mb-6">
                    Soluciones protésicas de última generación sobre implantes dentales, ofreciendo máxima estabilidad y estética natural.
                  </p>
                </motion.div>

                <motion.div variants={fadeInUp} className="space-y-4 mb-8">
                  <h3 className="font-semibold text-foreground text-lg">Servicios de Implantología:</h3>
                  <div className="space-y-3">
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Coronas sobre Implantes</p>
                        <p className="text-sm text-muted-foreground">Restauración unitaria con máxima estética</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Puentes sobre Implantes</p>
                        <p className="text-sm text-muted-foreground">Restauración de múltiples piezas fijas</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Prótesis Híbridas</p>
                        <p className="text-sm text-muted-foreground">Rehabilitación completa atornillada</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="w-5 h-5 text-primary mt-0.5 flex-shrink-0" />
                      <div>
                        <p className="font-medium">Sobredentaduras</p>
                        <p className="text-sm text-muted-foreground">Prótesis removibles con retención sobre implantes</p>
                      </div>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp} className="bg-muted/30 rounded-lg p-6 mb-6">
                  <div className="flex items-start gap-3">
                    <Microscope className="w-6 h-6 text-primary flex-shrink-0 mt-1" />
                    <div>
                      <h4 className="font-semibold mb-2">Compatibilidad Universal</h4>
                      <p className="text-sm text-muted-foreground">
                        Trabajamos con las principales marcas de implantes: Straumann, Nobel Biocare, Zimmer, Biomet, y más.
                      </p>
                    </div>
                  </div>
                </motion.div>

                <motion.div variants={fadeInUp}>
                  <Button size="lg">
                    <Phone className="w-5 h-5 mr-2" />
                    Consultar Compatibilidad
                  </Button>
                </motion.div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Process Section */}
        <section className="py-20 bg-muted/20">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Nuestro Proceso de Trabajo
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Un flujo de trabajo profesional que garantiza resultados excepcionales
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-6xl mx-auto"
            >
              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xl font-bold mb-4">
                      1
                    </div>
                    <h3 className="text-lg font-bold text-foreground mb-2">Recepción</h3>
                    <p className="text-sm text-muted-foreground">
                      Recibimos su orden con especificaciones detalladas e impresiones
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xl font-bold mb-4">
                      2
                    </div>
                    <h3 className="text-lg font-bold text-foreground mb-2">Diseño</h3>
                    <p className="text-sm text-muted-foreground">
                      Planificación técnica y diseño digital del trabajo protésico
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xl font-bold mb-4">
                      3
                    </div>
                    <h3 className="text-lg font-bold text-foreground mb-2">Fabricación</h3>
                    <p className="text-sm text-muted-foreground">
                      Elaboración con precisión técnica y control de calidad
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xl font-bold mb-4">
                      4
                    </div>
                    <h3 className="text-lg font-bold text-foreground mb-2">Entrega</h3>
                    <p className="text-sm text-muted-foreground">
                      Entrega puntual del trabajo terminado a su consultorio
                    </p>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* CTA Section */}
        <section className="py-20 bg-primary text-primary-foreground">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="max-w-4xl mx-auto text-center"
            >
              <motion.h2 variants={fadeInUp} className="text-3xl md:text-4xl font-bold mb-6">
                ¿Necesita Más Información?
              </motion.h2>
              <motion.p variants={fadeInUp} className="text-lg mb-8 opacity-90">
                Nuestro equipo está listo para asesorarle sobre el mejor servicio para sus pacientes
              </motion.p>
              
              <motion.div variants={fadeInUp} className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button size="lg" variant="secondary">
                  <Phone className="w-5 h-5 mr-2" />
                  (33) 1234-5678
                </Button>
                <Button size="lg" variant="outline" className="bg-white/10 border-white/20 hover:bg-white/20">
                  Solicitar Cotización
                  <ArrowRight className="w-5 h-5 ml-2" />
                </Button>
              </motion.div>
            </motion.div>
          </div>
        </section>
      </div>
    </>
  );
}
