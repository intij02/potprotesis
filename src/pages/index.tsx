import { motion } from 'motion/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { 
  CheckCircle2, 
  Users, 
  Phone, 
  Mail,
  MessageCircle,
  ArrowRight,
  Microscope,
  Shield,
  Zap
} from 'lucide-react';

/**
 * POT Prótesis Dental - Homepage
 * Professional dental laboratory landing page
 */
export default function HomePage() {
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
      <title>POT Prótesis Dental - Laboratorio Profesional en Guadalajara</title>
      <meta name="description" content="Laboratorio especializado en prótesis dental de alta calidad. Coronas, puentes e implantes para dentistas y clínicas en Guadalajara." />

      <div className="min-h-screen">
        {/* Hero Section */}
        <section className="relative h-[600px] lg:h-[700px] flex items-center overflow-hidden">
          <div className="absolute inset-0">
            <img 
              src="/media/pages-home-gallery-3-94a5fe60.jpg" 
              alt="Prótesis dental profesional"
              className="w-full h-full object-cover"
            />
            <div className="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/85 to-gray-900/70" />
          </div>
          
          <div className="container mx-auto px-4 relative z-10">
            <div className="max-w-2xl">
              <motion.div
                initial="hidden"
                animate="visible"
                variants={staggerContainer}
              >
                <motion.div variants={fadeInUp} className="mb-4">
                  <Badge className="bg-primary/20 text-primary border-primary/30 hover:bg-primary/30">
                    Laboratorio Profesional
                  </Badge>
                </motion.div>
                
                <motion.h1 
                  variants={fadeInUp}
                  className="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight"
                >
                  Prótesis Dental de Alta Calidad para su Consultorio
                </motion.h1>
                
                <motion.p 
                  variants={fadeInUp}
                  className="text-lg md:text-xl text-gray-200 mb-8"
                >
                  Elaboramos coronas, puentes y prótesis con precisión técnica y materiales de primera calidad. Servicio profesional para dentistas en Guadalajara.
                </motion.p>
                
                <motion.div 
                  variants={fadeInUp}
                  className="flex flex-col sm:flex-row gap-4"
                >
                  <Button size="lg" className="text-base">
                    <Phone className="w-5 h-5 mr-2" />
                    Solicitar Información
                  </Button>
                  <Button size="lg" variant="outline" className="text-base bg-white/10 backdrop-blur-sm border-white/20 text-white hover:bg-white/20">
                    <MessageCircle className="w-5 h-5 mr-2" />
                    WhatsApp
                  </Button>
                </motion.div>

                <motion.div 
                  variants={fadeInUp}
                  className="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-white/20"
                >
                  <div>
                    <div className="text-3xl font-bold text-primary mb-1">15+</div>
                    <div className="text-sm text-gray-300">Años de Experiencia</div>
                  </div>
                  <div>
                    <div className="text-3xl font-bold text-primary mb-1">5000+</div>
                    <div className="text-sm text-gray-300">Casos Realizados</div>
                  </div>
                  <div>
                    <div className="text-3xl font-bold text-primary mb-1">100%</div>
                    <div className="text-sm text-gray-300">Satisfacción</div>
                  </div>
                </motion.div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Trust Signals */}
        <section className="py-12 bg-muted/30 border-y border-border">
          <div className="container mx-auto px-4">
            <motion.div 
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-3 gap-8"
            >
              <motion.div variants={fadeInUp} className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                  <Microscope className="w-6 h-6 text-primary" />
                </div>
                <div>
                  <h3 className="font-semibold text-foreground mb-1">Precisión Técnica</h3>
                  <p className="text-sm text-muted-foreground">Tecnología de última generación</p>
                </div>
              </motion.div>

              <motion.div variants={fadeInUp} className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                  <Shield className="w-6 h-6 text-primary" />
                </div>
                <div>
                  <h3 className="font-semibold text-foreground mb-1">Materiales Certificados</h3>
                  <p className="text-sm text-muted-foreground">Calidad garantizada</p>
                </div>
              </motion.div>

              <motion.div variants={fadeInUp} className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                  <Zap className="w-6 h-6 text-primary" />
                </div>
                <div>
                  <h3 className="font-semibold text-foreground mb-1">Entrega Rápida</h3>
                  <p className="text-sm text-muted-foreground">Tiempos optimizados</p>
                </div>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Services Section */}
        <section className="py-20 bg-background">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Nuestros Servicios
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Soluciones profesionales en prótesis dental con los más altos estándares de calidad
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 lg:grid-cols-3 gap-8"
            >
              {/* Service 1 - Coronas y Puentes */}
              <motion.div variants={fadeInUp}>
                <Card className="overflow-hidden h-full hover:shadow-lg transition-shadow duration-300">
                  <div className="aspect-[4/3] overflow-hidden">
                    <img 
                      src="/media/pages-home-gallery-3-e1a8d6f3.jpg"
                      alt="Coronas y puentes dentales"
                      className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                  <CardContent className="p-6">
                    <h3 className="text-xl font-bold text-foreground mb-3">Coronas y Puentes</h3>
                    <p className="text-muted-foreground mb-4">
                      Restauraciones fijas de alta precisión en porcelana, zirconia y metal-porcelana. Estética natural y durabilidad garantizada.
                    </p>
                    <ul className="space-y-2 mb-6">
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Coronas individuales y puentes fijos</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Materiales premium certificados</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Ajuste perfecto y estética superior</span>
                      </li>
                    </ul>
                    <Button variant="outline" className="w-full">
                      Solicitar Información
                      <ArrowRight className="w-4 h-4 ml-2" />
                    </Button>
                  </CardContent>
                </Card>
              </motion.div>

              {/* Service 2 - Prótesis Removibles */}
              <motion.div variants={fadeInUp}>
                <Card className="overflow-hidden h-full hover:shadow-lg transition-shadow duration-300">
                  <div className="aspect-[4/3] overflow-hidden">
                    <img 
                      src="/media/pages-home-gallery-3-94a5fe60.jpg"
                      alt="Prótesis removibles"
                      className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                  <CardContent className="p-6">
                    <h3 className="text-xl font-bold text-foreground mb-3">Prótesis Removibles</h3>
                    <p className="text-muted-foreground mb-4">
                      Dentaduras parciales y completas con diseño anatómico. Comodidad y funcionalidad para sus pacientes.
                    </p>
                    <ul className="space-y-2 mb-6">
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Prótesis parciales y totales</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Resinas de alta resistencia</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Diseño personalizado</span>
                      </li>
                    </ul>
                    <Button variant="outline" className="w-full">
                      Solicitar Información
                      <ArrowRight className="w-4 h-4 ml-2" />
                    </Button>
                  </CardContent>
                </Card>
              </motion.div>

              {/* Service 3 - Implantes */}
              <motion.div variants={fadeInUp}>
                <Card className="overflow-hidden h-full hover:shadow-lg transition-shadow duration-300">
                  <div className="aspect-[4/3] overflow-hidden">
                    <img 
                      src="/media/pages-home-gallery-3-e1a8d6f3.jpg"
                      alt="Prótesis sobre implantes"
                      className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                  <CardContent className="p-6">
                    <h3 className="text-xl font-bold text-foreground mb-3">Prótesis sobre Implantes</h3>
                    <p className="text-muted-foreground mb-4">
                      Soluciones avanzadas sobre implantes dentales. Restauraciones fijas y removibles con máxima estabilidad.
                    </p>
                    <ul className="space-y-2 mb-6">
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Coronas y puentes sobre implantes</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Compatibilidad con principales marcas</span>
                      </li>
                      <li className="flex items-start gap-2 text-sm">
                        <CheckCircle2 className="w-4 h-4 text-primary mt-0.5 flex-shrink-0" />
                        <span>Precisión milimétrica</span>
                      </li>
                    </ul>
                    <Button variant="outline" className="w-full">
                      Solicitar Información
                      <ArrowRight className="w-4 h-4 ml-2" />
                    </Button>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Process Section */}
        <section className="py-20 bg-muted/30">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Proceso de Trabajo
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Un flujo de trabajo eficiente para garantizar resultados excepcionales
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto"
            >
              <motion.div variants={fadeInUp} className="text-center">
                <div className="w-16 h-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                  1
                </div>
                <h3 className="text-xl font-bold text-foreground mb-2">Pedido</h3>
                <p className="text-muted-foreground">
                  Recibimos su orden con especificaciones detalladas y material de impresión
                </p>
              </motion.div>

              <motion.div variants={fadeInUp} className="text-center">
                <div className="w-16 h-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                  2
                </div>
                <h3 className="text-xl font-bold text-foreground mb-2">Elaboración</h3>
                <p className="text-muted-foreground">
                  Nuestro equipo técnico elabora su prótesis con precisión y cuidado
                </p>
              </motion.div>

              <motion.div variants={fadeInUp} className="text-center">
                <div className="w-16 h-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                  3
                </div>
                <h3 className="text-xl font-bold text-foreground mb-2">Entrega</h3>
                <p className="text-muted-foreground">
                  Entregamos el trabajo terminado en tiempo y forma a su consultorio
                </p>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Gallery Section */}
        <section className="py-20 bg-background">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Galería de Trabajos
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Ejemplos de nuestra calidad y precisión en cada caso
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
              <motion.div variants={fadeInUp} className="aspect-square overflow-hidden rounded-lg">
                <img 
                  src="/media/pages-home-gallery-3-94a5fe60.jpg"
                  alt="Trabajo realizado 1"
                  className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                />
              </motion.div>
              <motion.div variants={fadeInUp} className="aspect-square overflow-hidden rounded-lg">
                <img 
                  src="/media/pages-home-gallery-3-e1a8d6f3.jpg"
                  alt="Trabajo realizado 2"
                  className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                />
              </motion.div>
              <motion.div variants={fadeInUp} className="aspect-square overflow-hidden rounded-lg">
                <img 
                  src="/media/pages-home-gallery-3-94a5fe60.jpg"
                  alt="Trabajo realizado 3"
                  className="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                />
              </motion.div>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mt-12"
            >
              <Button size="lg" variant="outline">
                Ver Más Trabajos
                <ArrowRight className="w-5 h-5 ml-2" />
              </Button>
            </motion.div>
          </div>
        </section>

        {/* Testimonials Section */}
        <section className="py-20 bg-muted/30">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Lo Que Dicen Nuestros Clientes
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                La confianza de dentistas profesionales en Guadalajara
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto"
            >
              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="flex items-center gap-4 mb-4">
                      <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <Users className="w-6 h-6 text-primary" />
                      </div>
                      <div>
                        <div className="font-semibold text-foreground">Dr. Carlos Mendoza</div>
                        <div className="text-sm text-muted-foreground">Clínica Dental Guadalajara</div>
                      </div>
                    </div>
                    <p className="text-muted-foreground italic">
                      "Excelente calidad en todas las prótesis. Los tiempos de entrega son puntuales y la precisión es impecable. Mis pacientes están muy satisfechos con los resultados."
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="flex items-center gap-4 mb-4">
                      <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <Users className="w-6 h-6 text-primary" />
                      </div>
                      <div>
                        <div className="font-semibold text-foreground">Dra. Ana Martínez</div>
                        <div className="text-sm text-muted-foreground">Centro Odontológico</div>
                      </div>
                    </div>
                    <p className="text-muted-foreground italic">
                      "Trabajo con POT desde hace años. La atención es profesional y los trabajos siempre cumplen con las especificaciones. Totalmente recomendable."
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
                ¿Listo para Trabajar con Nosotros?
              </motion.h2>
              <motion.p variants={fadeInUp} className="text-lg mb-8 opacity-90">
                Contáctenos hoy y descubra por qué somos el laboratorio de confianza para dentistas en Guadalajara
              </motion.p>
              
              <motion.div variants={fadeInUp} className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <Card className="bg-white/10 backdrop-blur-sm border-white/20">
                  <CardContent className="p-6 text-center">
                    <Phone className="w-8 h-8 mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">Teléfono</h3>
                    <a href="tel:+523334735108" className="hover:underline">
                      (33) 3473-5108
                    </a>
                  </CardContent>
                </Card>

                <Card className="bg-white/10 backdrop-blur-sm border-white/20">
                  <CardContent className="p-6 text-center">
                    <MessageCircle className="w-8 h-8 mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">WhatsApp</h3>
                    <a href="https://wa.me/523311300050" className="hover:underline">
                      Enviar Mensaje
                    </a>
                  </CardContent>
                </Card>

                <Card className="bg-white/10 backdrop-blur-sm border-white/20">
                  <CardContent className="p-6 text-center">
                    <Mail className="w-8 h-8 mx-auto mb-3" />
                    <h3 className="font-semibold mb-2">Email</h3>
                    <a href="mailto:contacto@potprotesisdental.com" className="hover:underline">
                      contacto@potprotesisdental.com
                    </a>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Button size="lg" variant="secondary" className="text-base">
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
