import { motion } from 'motion/react';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { useState } from 'react';
import { X, Phone, MessageCircle } from 'lucide-react';

/**
 * Galería Page - POT Prótesis Dental
 * Portfolio showcase of completed dental prosthetic work
 */
export default function GaleriaPage() {
  const [selectedImage, setSelectedImage] = useState<number | null>(null);
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
        staggerChildren: 0.1
      }
    }
  } as const;

  const galleryItems = [
    {
      id: 1,
      src: '/media/pages-home-gallery-3-94a5fe60.jpg',
      title: 'Corona de Porcelana',
      category: 'Coronas',
      description: 'Corona individual en porcelana con ajuste perfecto y estética natural'
    },
    {
      id: 2,
      src: '/media/pages-home-gallery-3-e1a8d6f3.jpg',
      title: 'Puente Fijo',
      category: 'Puentes',
      description: 'Puente de tres unidades en metal-porcelana con excelente oclusión'
    },
    {
      id: 3,
      src: '/media/pages-home-gallery-3-94a5fe60.jpg',
      title: 'Corona sobre Implante',
      category: 'Implantes',
      description: 'Corona de zirconia sobre implante con pilar personalizado'
    },
    {
      id: 4,
      src: '/media/pages-home-gallery-3-e1a8d6f3.jpg',
      title: 'Prótesis Removible',
      category: 'Removibles',
      description: 'Prótesis parcial con diseño anatómico y retención óptima'
    },
    {
      id: 5,
      src: '/media/pages-home-gallery-3-94a5fe60.jpg',
      title: 'Restauración Estética',
      category: 'Coronas',
      description: 'Restauración anterior con caracterización natural'
    },
    {
      id: 6,
      src: '/media/pages-home-gallery-3-e1a8d6f3.jpg',
      title: 'Proceso de Fabricación',
      category: 'Laboratorio',
      description: 'Nuestro equipo técnico trabajando con precisión'
    },
    {
      id: 7,
      src: '/media/pages-home-gallery-3-94a5fe60.jpg',
      title: 'Puente Metal-Porcelana',
      category: 'Puentes',
      description: 'Puente posterior con estructura metálica y recubrimiento estético'
    },
    {
      id: 8,
      src: '/media/pages-home-gallery-3-e1a8d6f3.jpg',
      title: 'Implante con Pilar',
      category: 'Implantes',
      description: 'Sistema completo de implante con pilar y corona'
    },
    {
      id: 9,
      src: '/media/pages-home-gallery-3-94a5fe60.jpg',
      title: 'Prótesis Total',
      category: 'Removibles',
      description: 'Dentadura completa con diseño personalizado'
    }
  ];

  const categories = ['Todos', 'Coronas', 'Puentes', 'Implantes', 'Removibles', 'Laboratorio'];
  const [activeCategory, setActiveCategory] = useState('Todos');

  const filteredItems = activeCategory === 'Todos' 
    ? galleryItems 
    : galleryItems.filter(item => item.category === activeCategory);

  return (
    <>
      <title>Galería de Trabajos - POT Prótesis Dental</title>
      <meta name="description" content="Galería de trabajos realizados por POT Prótesis Dental. Coronas, puentes, implantes y prótesis removibles de alta calidad." />

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
                <Badge className="mb-4">Nuestros Trabajos</Badge>
                <h1 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
                  Galería de Casos Realizados
                </h1>
                <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                  Ejemplos de nuestra calidad, precisión técnica y atención al detalle en cada trabajo protésico
                </p>
              </motion.div>
            </motion.div>
          </div>
        </section>

        {/* Category Filter */}
        <section className="py-8 bg-background border-b border-border sticky top-20 z-40 backdrop-blur-sm bg-background/95">
          <div className="container mx-auto px-4">
            <div className="flex flex-wrap justify-center gap-3">
              {categories.map((category) => (
                <Button
                  key={category}
                  variant={activeCategory === category ? 'default' : 'outline'}
                  onClick={() => setActiveCategory(category)}
                  size="sm"
                >
                  {category}
                </Button>
              ))}
            </div>
          </div>
        </section>

        {/* Gallery Grid */}
        <section className="py-16 bg-background">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              animate="visible"
              variants={staggerContainer}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
              {filteredItems.map((item, index) => (
                <motion.div
                  key={item.id}
                  variants={fadeInUp}
                  className="group cursor-pointer"
                  onClick={() => setSelectedImage(index)}
                >
                  <div className="relative aspect-square overflow-hidden rounded-lg bg-muted">
                    <img 
                      src={item.src}
                      alt={item.title}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                      <div className="absolute bottom-0 left-0 right-0 p-6">
                        <Badge className="mb-2">{item.category}</Badge>
                        <h3 className="text-lg font-bold text-white mb-1">{item.title}</h3>
                        <p className="text-sm text-gray-200">{item.description}</p>
                      </div>
                    </div>
                  </div>
                </motion.div>
              ))}
            </motion.div>

            {filteredItems.length === 0 && (
              <div className="text-center py-16">
                <p className="text-muted-foreground">No hay trabajos en esta categoría</p>
              </div>
            )}
          </div>
        </section>

        {/* Lightbox Modal */}
        {selectedImage !== null && (
          <div 
            className="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
            onClick={() => setSelectedImage(null)}
          >
            <button
              onClick={() => setSelectedImage(null)}
              className="absolute top-4 right-4 text-white hover:text-primary transition-colors"
              aria-label="Cerrar"
            >
              <X className="w-8 h-8" />
            </button>

            <div className="max-w-6xl w-full" onClick={(e) => e.stopPropagation()}>
              <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div className="aspect-square overflow-hidden rounded-lg">
                  <img 
                    src={filteredItems[selectedImage].src}
                    alt={filteredItems[selectedImage].title}
                    className="w-full h-full object-cover"
                  />
                </div>

                <div className="text-white">
                  <Badge className="mb-4">{filteredItems[selectedImage].category}</Badge>
                  <h2 className="text-3xl font-bold mb-4">{filteredItems[selectedImage].title}</h2>
                  <p className="text-lg text-gray-300 mb-8">{filteredItems[selectedImage].description}</p>

                  <div className="flex gap-4">
                    <Button
                      onClick={(e) => {
                        e.stopPropagation();
                        if (selectedImage > 0) setSelectedImage(selectedImage - 1);
                      }}
                      disabled={selectedImage === 0}
                      variant="outline"
                      className="bg-white/10 border-white/20 text-white hover:bg-white/20"
                    >
                      Anterior
                    </Button>
                    <Button
                      onClick={(e) => {
                        e.stopPropagation();
                        if (selectedImage < filteredItems.length - 1) setSelectedImage(selectedImage + 1);
                      }}
                      disabled={selectedImage === filteredItems.length - 1}
                      variant="outline"
                      className="bg-white/10 border-white/20 text-white hover:bg-white/20"
                    >
                      Siguiente
                    </Button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}

        {/* Stats Section */}
        <section className="py-16 bg-muted/20">
          <div className="container mx-auto px-4">
            <motion.div
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              variants={staggerContainer}
              className="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto"
            >
              <motion.div variants={fadeInUp} className="text-center">
                <div className="text-4xl font-bold text-primary mb-2">5000+</div>
                <div className="text-sm text-muted-foreground">Casos Realizados</div>
              </motion.div>
              <motion.div variants={fadeInUp} className="text-center">
                <div className="text-4xl font-bold text-primary mb-2">15+</div>
                <div className="text-sm text-muted-foreground">Años de Experiencia</div>
              </motion.div>
              <motion.div variants={fadeInUp} className="text-center">
                <div className="text-4xl font-bold text-primary mb-2">100%</div>
                <div className="text-sm text-muted-foreground">Satisfacción</div>
              </motion.div>
              <motion.div variants={fadeInUp} className="text-center">
                <div className="text-4xl font-bold text-primary mb-2">200+</div>
                <div className="text-sm text-muted-foreground">Dentistas Confían</div>
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
                ¿Le Gustaría Trabajar con Esta Calidad?
              </motion.h2>
              <motion.p variants={fadeInUp} className="text-lg mb-8 opacity-90">
                Contáctenos hoy y descubra cómo podemos ayudarle a ofrecer los mejores resultados a sus pacientes
              </motion.p>
              
              <motion.div variants={fadeInUp} className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button size="lg" variant="secondary">
                  <Phone className="w-5 h-5 mr-2" />
                  (33) 1234-5678
                </Button>
                <Button size="lg" variant="outline" className="bg-white/10 border-white/20 hover:bg-white/20" asChild>
                  <a href={whatsappUrl} target="_blank" rel="noopener noreferrer">
                    <MessageCircle className="w-5 h-5 mr-2" />
                    WhatsApp
                  </a>
                </Button>
              </motion.div>
            </motion.div>
          </div>
        </section>
      </div>
    </>
  );
}
