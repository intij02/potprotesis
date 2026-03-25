import { motion } from 'motion/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import StaticMap from '@/components/StaticMap';
import { 
  Phone, 
  Mail, 
  MapPin, 
  Clock,
  MessageCircle,
  Send,
  CheckCircle2
} from 'lucide-react';
import { useState } from 'react';

/**
 * Contacto Page - POT Prótesis Dental
 * Contact information and inquiry form
 */
export default function ContactoPage() {
  const [formData, setFormData] = useState({
    nombre: '',
    consultorio: '',
    telefono: '',
    email: '',
    servicio: '',
    mensaje: ''
  });

  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // Simulate form submission
    setIsSubmitted(true);
    setTimeout(() => {
      setIsSubmitted(false);
      setFormData({
        nombre: '',
        consultorio: '',
        telefono: '',
        email: '',
        servicio: '',
        mensaje: ''
      });
    }, 3000);
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

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
      <meta name="description" content="Contáctenos para solicitar información, cotizaciones o agendar una visita. Laboratorio dental en Guadalajara al servicio de profesionales." />

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
              <motion.div variants={fadeInUp}>
                <Badge className="mb-4">Estamos Para Servirle</Badge>
                <h1 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
                  Contáctenos
                </h1>
                <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                  Nuestro equipo está listo para atender sus consultas y brindarle la mejor asesoría profesional
                </p>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Contact Info Cards */}
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
                    <a href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer" className="text-sm text-muted-foreground hover:text-primary transition-colors">
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
                      Lun - Vie: 10:00 - 14:00<br />16:00 - 20:00
                    </p>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Main Content - Form and Location */}
        <section className="py-16 bg-muted/20">
          <div className="container mx-auto px-4">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
              {/* Contact Form */}
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={fadeInUp}
              >
                <Card>
                  <CardContent className="p-8">
                    <h2 className="text-2xl font-bold text-foreground mb-2">
                      Envíenos un Mensaje
                    </h2>
                    <p className="text-muted-foreground mb-6">
                      Complete el formulario y nos pondremos en contacto con usted a la brevedad
                    </p>

                    {isSubmitted ? (
                      <motion.div
                        initial={{ opacity: 0, scale: 0.9 }}
                        animate={{ opacity: 1, scale: 1 }}
                        className="text-center py-12"
                      >
                        <div className="w-16 h-16 rounded-full bg-accent/10 flex items-center justify-center mx-auto mb-4">
                          <CheckCircle2 className="w-8 h-8 text-accent" />
                        </div>
                        <h3 className="text-xl font-semibold mb-2">¡Mensaje Enviado!</h3>
                        <p className="text-muted-foreground">
                          Gracias por contactarnos. Responderemos pronto.
                        </p>
                      </motion.div>
                    ) : (
                      <form onSubmit={handleSubmit} className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <div className="space-y-2">
                            <Label htmlFor="nombre">Nombre Completo *</Label>
                            <Input
                              id="nombre"
                              name="nombre"
                              value={formData.nombre}
                              onChange={handleChange}
                              placeholder="Dr. Juan Pérez"
                              required
                            />
                          </div>
                          <div className="space-y-2">
                            <Label htmlFor="consultorio">Consultorio</Label>
                            <Input
                              id="consultorio"
                              name="consultorio"
                              value={formData.consultorio}
                              onChange={handleChange}
                              placeholder="Clínica Dental"
                            />
                          </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <div className="space-y-2">
                            <Label htmlFor="telefono">Teléfono *</Label>
                            <Input
                              id="telefono"
                              name="telefono"
                              type="tel"
                              value={formData.telefono}
                              onChange={handleChange}
                              placeholder="(33) 1234-5678"
                              required
                            />
                          </div>
                          <div className="space-y-2">
                            <Label htmlFor="email">Email *</Label>
                            <Input
                              id="email"
                              name="email"
                              type="email"
                              value={formData.email}
                              onChange={handleChange}
                              placeholder="correo@ejemplo.com"
                              required
                            />
                          </div>
                        </div>

                        <div className="space-y-2">
                          <Label htmlFor="servicio">Servicio de Interés</Label>
                          <select
                            id="servicio"
                            name="servicio"
                            value={formData.servicio}
                            onChange={handleChange}
                            className="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                          >
                            <option value="">Seleccione un servicio</option>
                            <option value="coronas">Coronas y Puentes</option>
                            <option value="removibles">Prótesis Removibles</option>
                            <option value="implantes">Prótesis sobre Implantes</option>
                            <option value="otro">Otro</option>
                          </select>
                        </div>

                        <div className="space-y-2">
                          <Label htmlFor="mensaje">Mensaje *</Label>
                          <Textarea
                            id="mensaje"
                            name="mensaje"
                            value={formData.mensaje}
                            onChange={handleChange}
                            placeholder="Cuéntenos sobre su consulta o requerimiento..."
                            rows={5}
                            required
                          />
                        </div>

                        <Button type="submit" size="lg" className="w-full">
                          <Send className="w-5 h-5 mr-2" />
                          Enviar Mensaje
                        </Button>
                      </form>
                    )}
                  </CardContent>
                </Card>
              </motion.div>

              {/* Location and Additional Info */}
              <motion.div
                initial="hidden"
                whileInView="visible"
                viewport={{ once: true }}
                variants={staggerContainer}
                className="space-y-6"
              >
                {/* Location Card */}
                <motion.div variants={fadeInUp}>
                  <Card>
                    <CardContent className="p-8">
                      <div className="flex items-start gap-4 mb-6">
                        <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                          <MapPin className="w-6 h-6 text-primary" />
                        </div>
                        <div>
                          <h3 className="text-xl font-bold text-foreground mb-2">
                            Nuestra Ubicación
                          </h3>
                          <p className="text-muted-foreground">
                            C. Reforma 1752<br />
                            Ladrón de Guevara<br />
                            44600 Guadalajara, Jalisco
                          </p>
                        </div>
                      </div>

                      {/* Google Maps */}
                      <div className="rounded-lg overflow-hidden">
                        <StaticMap 
                          location="C. Reforma 1752, Ladrón de Guevara, 44600 Guadalajara, Jalisco, Mexico" 
                          height={400}
                          zoom={16}
                        />
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>

                {/* Business Hours */}
                <motion.div variants={fadeInUp}>
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

                {/* Quick Contact */}
                <motion.div variants={fadeInUp}>
                  <Card className="bg-primary text-primary-foreground">
                    <CardContent className="p-8">
                      <h3 className="text-xl font-bold mb-4">
                        ¿Necesita Atención Inmediata?
                      </h3>
                      <p className="mb-6 opacity-90">
                        Contáctenos directamente por WhatsApp para una respuesta rápida
                      </p>
                      <Button 
                        size="lg" 
                        variant="secondary"
                        className="w-full"
                        asChild
                      >
                        <a href="https://wa.me/523311300050" target="_blank" rel="noopener noreferrer">
                          <MessageCircle className="w-5 h-5 mr-2" />
                          Abrir WhatsApp
                        </a>
                      </Button>
                    </CardContent>
                  </Card>
                </motion.div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* FAQ Section */}
        <section className="py-16 bg-background">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={fadeInUp}
              className="max-w-3xl mx-auto text-center mb-12"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Preguntas Frecuentes
              </h2>
              <p className="text-lg text-muted-foreground">
                Respuestas a las consultas más comunes
              </p>
            </motion.div>

            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="max-w-3xl mx-auto space-y-4"
            >
              <motion.div variants={fadeInUp}>
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-lg mb-2">
                      ¿Cuál es el tiempo de entrega de los trabajos?
                    </h3>
                    <p className="text-muted-foreground">
                      Los tiempos varían según el tipo de trabajo. Coronas y puentes: 5-7 días hábiles. Prótesis removibles: 7-10 días hábiles. Trabajos sobre implantes: 7-10 días hábiles.
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-lg mb-2">
                      ¿Ofrecen servicio de recolección y entrega?
                    </h3>
                    <p className="text-muted-foreground">
                      Sí, contamos con servicio de mensajería para recolección de impresiones y entrega de trabajos terminados en Guadalajara y zona metropolitana.
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-lg mb-2">
                      ¿Qué marcas de implantes manejan?
                    </h3>
                    <p className="text-muted-foreground">
                      Trabajamos con las principales marcas: Straumann, Nobel Biocare, Zimmer Biomet, Dentsply Sirona, y más. Contáctenos para consultar compatibilidad con su sistema.
                    </p>
                  </CardContent>
                </Card>
              </motion.div>

              <motion.div variants={fadeInUp}>
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-lg mb-2">
                      ¿Ofrecen garantía en sus trabajos?
                    </h3>
                    <p className="text-muted-foreground">
                      Sí, todos nuestros trabajos cuentan con garantía de calidad. Los términos específicos se detallan en cada orden de trabajo.
                    </p>
                  </CardContent>
                </Card>
              </motion.div>
            </motion.div>
          </div>
        </section>
      </div>
    </>
  );
}
