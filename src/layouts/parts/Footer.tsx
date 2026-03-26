import { Link } from 'react-router-dom';
import { Phone, MapPin, Facebook } from 'lucide-react';

/**
 * Footer component for POT Prótesis Dental
 * Professional dental laboratory footer with contact information
 */
export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="mt-auto border-t border-border bg-muted/30">
      <div className="container mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          {/* Brand */}
          <div>
            <img
              src="/media/logo-pot.png"
              alt="POT Prótesis Dental"
              className="h-12 w-auto object-contain mb-4"
            />
            <p className="text-sm text-muted-foreground mb-4">
              Laboratorio especializado en prótesis dental de alta calidad para dentistas y clínicas en Guadalajara.
            </p>
            <a
              href="https://www.facebook.com/potguadalajara"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors"
            >
              <Facebook className="w-5 h-5" />
              Síguenos en Facebook
            </a>
          </div>

          {/* Services */}
          <div>
            <h3 className="font-semibold text-foreground mb-4">Servicios</h3>
            <nav className="flex flex-col gap-2">
              <Link to="/servicios" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                Coronas y Puentes
              </Link>
              <Link to="/servicios" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                Prótesis Removibles
              </Link>
              <Link to="/servicios" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                Implantes Dentales
              </Link>
              <Link to="/galeria" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                Galería de Trabajos
              </Link>
            </nav>
          </div>

          {/* Contact */}
          <div>
            <h3 className="font-semibold text-foreground mb-4">Contacto</h3>
            <div className="flex flex-col gap-3">
              <a href="tel:+523334735108" className="flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors">
                <Phone className="w-4 h-4" />
                (33) 3473-5108
              </a>
              <div className="flex items-start gap-2 text-sm text-muted-foreground">
                <MapPin className="w-4 h-4 mt-0.5 flex-shrink-0" />
                <span>C. Reforma 1752<br />Ladrón de Guevara<br />44600 Guadalajara, Jal.</span>
              </div>
            </div>
          </div>
        </div>

        <div className="pt-6 border-t border-border">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            <div className="text-sm text-muted-foreground">
              © {currentYear} POT Prótesis Dental. Todos los derechos reservados.
            </div>
            <nav className="flex gap-6">
              <Link to="/privacidad" className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                Privacidad
              </Link>
              <Link to="/terminos" className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                Términos
              </Link>
            </nav>
          </div>
        </div>
      </div>
    </footer>
  );
}
