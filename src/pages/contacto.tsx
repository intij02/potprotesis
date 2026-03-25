import { motion } from 'motion/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import StaticMap from '@/components/StaticMap';
import {
  Phone,
  Mail,
  MapPin,
  Clock,
  MessageCircle,
} from 'lucide-react';

/**
 * Contacto Page - POT Prótesis Dental
 * Contact information page without contact form.
 */
export default function ContactoPage() {
  const whatsappUrl = 'https://wa.me/523311300050';

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
      <title>Contacto - POT Prótesis Dental</title>
      <meta name="description" content="Contáctenos por WhatsApp, teléfono o correo. Laboratorio dental en Guadalajara al servicio de profesionales." />

      <div className="min-h-screen">
        <section className="relative py-20 bg-gradient-to-br from-primary/5 via-background to-accent/5">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              animate="visible"
              variants={staggerContainer}
              className="max-w-4xl mx-auto text-center"
            >
              <motion.div variants={fadeInUp}>
                <Badge className="mb-4">Estamos Para Servirle</Badge>
                <h1 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
                  Contáctenos
                </h1>
                <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                  Nuestro equipo está listo para atender sus consultas y brindarle la mejor asesoría profesional.
                </p>
              </motion.div>
            </motion.div>
          </div>
        </section>

        <section className="py-16 bg-background">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto"
            >
              <motion.div variants={fadeInUp}>
                <Card className="h-full hover:shadow-lg transition-shadow">
                  <CardContent className="p-6 text-center">
                    <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                      <Phone className="w-6 h-6 text-primary" />
                    </div>
                    <h3 className="font-semibold mb-2">Teléfono</h3>
                    <a href="tel:+523334735108" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                      (33) 3473-5108
                    </a>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full hover:shadow-lg transition-shadow">
                  <CardContent className="p-6 text-center">
                    <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                      <MessageCircle className="w-6 h-6 text-primary" />
                    </div>
                    <h3 className="font-semibold mb-2">WhatsApp</h3>
                    <a href={whatsappUrl} target="_blank" rel="noopener noreferrer" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                      (33) 1130-0050
                    </a>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full hover:shadow-lg transition-shadow">
                  <CardContent className="p-6 text-center">
                    <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                      <Mail className="w-6 h-6 text-primary" />
                    </div>
                    <h3 className="font-semibold mb-2">Email</h3>
                    <a href="mailto:contacto@potprotesisdental.com" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                      contacto@potprotesisdental.com
                    </a>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card className="h-full hover:shadow-lg transition-shadow">
                  <CardContent className="p-6 text-center">
                    <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                      <Clock className="w-6 h-6 text-primary" />
                    </div>
                    <h3 className="font-semibold mb-2">Horario</h3>
                    <p className="text-sm text-muted-foreground">
                      Lun - Vie: 10:00 - 14:00
                      <br />
                      16:00 - 20:00
                    </p>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>

        <section className="py-16 bg-muted/20">
          <div className="container mx-auto px-4">
            <div className="max-w-5xl mx-auto space-y-6">
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={fadeInUp}
              >
                <Card>
                  <CardContent className="p-8">
                    <div className="flex items-start gap-4 mb-6">
                      <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <MapPin className="w-6 h-6 text-primary" />
                      </div>
                      <div>
                        <h2 className="text-2xl font-bold text-foreground mb-2">
                          Nuestra Ubicación
                        </h2>
                        <p className="text-muted-foreground">
                          C. Reforma 1752
                          <br />
                          Ladrón de Guevara
                          <br />
                          44600 Guadalajara, Jalisco
                        </p>
                      </div>
                    </div>

                    <div className="rounded-lg overflow-hidden">
                      <StaticMap
                        location="C. Reforma 1752, Ladrón de Guevara, 44600 Guadalajara, Jalisco, Mexico"
                        height={420}
                        zoom={16}
                      />
                    </div>
                  </CardContent>
                </Card>
              </motion.div>

              <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <motion.div
                  initial="hidden"
                  whileInView="visible"
                  viewport={{ once: true }}
                  variants={fadeInUp}
                >
                  <Card>
                    <CardContent className="p-8">
                      <h3 className="text-xl font-bold text-foreground mb-4">
                        Horario de Atención
                      </h3>
                      <div className="space-y-3">
                        <div className="flex justify-between items-center">
                          <span className="text-muted-foreground">Lunes</span>
                          <span className="font-semibold">10:00 AM - 2:00 PM, 4:00 PM - 8:00 PM</span>
                        </div>
                        <div className="flex justify-between items-center">
                          <span className="text-muted-foreground">Martes - Viernes</span>
                          <span className="font-semibold">10:00 AM - 2:00 PM, 4:00 PM - 8:00 PM</span>
                        </div>
                        <div className="flex justify-between items-center">
                          <span className="text-muted-foreground">Sábado</span>
                          <span className="font-semibold">Cerrado</span>
                        </div>
                        <div className="flex justify-between items-center">
                          <span className="text-muted-foreground">Domingo</span>
                          <span className="font-semibold">Cerrado</span>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>

                <motion.div
                  initial="hidden"
                  whileInView="visible"
                  viewport={{ once: true }}
                  variants={fadeInUp}
                >
                  <Card className="bg-primary text-primary-foreground h-full">
                    <CardContent className="p-8 flex h-full flex-col justify-between">
                      <div>
                        <h3 className="text-xl font-bold mb-4">
                          ¿Necesita Información?
                        </h3>
                        <p className="mb-6 opacity-90">
                          Escríbanos por WhatsApp para una respuesta rápida.
                        </p>
                      </div>
                      <Button size="lg" variant="secondary" className="w-full" asChild>
                        <a href={whatsappUrl} target="_blank" rel="noopener noreferrer">
                          <MessageCircle className="w-5 h-5 mr-2" />
                          Abrir WhatsApp
                        </a>
                      </Button>
                    </CardContent>
                  </Card>
                </motion.div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </>
  );
}
