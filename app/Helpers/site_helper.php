<?php

use App\Models\BlogPostModel;
use App\Models\GalleryItemModel;
use App\Models\ServiceModel;
use App\Models\SiteSettingModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

if (! function_exists('site_setting')) {
    function site_setting(string $key, ?string $default = null): ?string
    {
        static $settings = null;

        if ($settings === null) {
            $settings = [];

            try {
                $model = new SiteSettingModel();

                if ($model->db->tableExists('site_settings')) {
                    foreach ($model->findAll() as $row) {
                        $settings[$row['setting_key']] = $row['setting_value'];
                    }
                }
            } catch (Throwable) {
                $settings = [];
            }
        }

        return array_key_exists($key, $settings) ? (string) $settings[$key] : $default;
    }
}

if (! function_exists('site_datetime')) {
    function site_datetime(?string $value, string $format = 'd-m-Y - H:i A'): string
    {
        if ($value === null || trim($value) === '') {
            return '';
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return $value;
        }

        return date($format, $timestamp);
    }
}

if (! function_exists('site_services')) {
    function site_services(bool $activeOnly = true, ?int $limit = null): array
    {
        try {
            $model = new ServiceModel();

            if (! $model->db->tableExists('services')) {
                return site_default_services();
            }

            if ($activeOnly) {
                $model->where('is_active', 1);
            }

            $model->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');

            $rows = $limit !== null ? $model->findAll($limit) : $model->findAll();

            return $rows !== [] ? $rows : site_default_services();
        } catch (Throwable) {
            return site_default_services();
        }
    }
}

if (! function_exists('site_gallery_items')) {
    function site_gallery_items(bool $activeOnly = true, ?int $limit = null): array
    {
        try {
            $model = new GalleryItemModel();

            if (! $model->db->tableExists('gallery_items')) {
                return site_default_gallery_items();
            }

            if ($activeOnly) {
                $model->where('is_active', 1);
            }

            $model->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');

            $rows = $limit !== null ? $model->findAll($limit) : $model->findAll();

            return $rows !== [] ? $rows : site_default_gallery_items();
        } catch (Throwable) {
            return site_default_gallery_items();
        }
    }
}

if (! function_exists('site_blog_posts')) {
    function site_blog_posts(bool $activeOnly = true, ?int $limit = null): array
    {
        try {
            $model = new BlogPostModel();

            if (! $model->db->tableExists('blog_posts')) {
                return site_default_blog_posts();
            }

            if ($activeOnly) {
                $model->where('is_active', 1);
            }

            $model->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

            $rows = $limit !== null ? $model->findAll($limit) : $model->findAll();

            return $rows !== [] ? $rows : site_default_blog_posts();
        } catch (Throwable) {
            return site_default_blog_posts();
        }
    }
}

if (! function_exists('site_default_services')) {
    function site_default_services(): array
    {
        return [
            [
                'title' => 'Coronas y Puentes',
                'slug' => 'coronas-y-puentes',
                'summary' => 'Restauraciones fijas en porcelana, zirconia y metal-porcelana con estética natural.',
                'detail_content' => 'Restauraciones fijas diseñadas para ofrecer ajuste preciso, resistencia funcional y una integración estética acorde con la planeación clínica de cada caso.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'detail_images' => json_encode([
                    'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                    'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'sort_order' => 1,
                'is_active' => 1,
            ],
            [
                'title' => 'Prótesis Removibles',
                'slug' => 'protesis-removibles',
                'summary' => 'Dentaduras parciales y completas con diseño anatómico y enfoque en comodidad.',
                'detail_content' => 'Prótesis removibles elaboradas con enfoque anatómico, comodidad de uso y estabilidad, buscando facilitar la adaptación clínica y el desempeño funcional.',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'detail_images' => json_encode([
                    'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                    'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'sort_order' => 2,
                'is_active' => 1,
            ],
            [
                'title' => 'Prótesis sobre Implantes',
                'slug' => 'protesis-sobre-implantes',
                'summary' => 'Soluciones avanzadas con máxima estabilidad, ajuste y precisión milimétrica.',
                'detail_content' => 'Soluciones sobre implantes enfocadas en ajuste, estabilidad y exactitud de laboratorio, alineadas con los requerimientos funcionales y estéticos del tratamiento.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'detail_images' => json_encode([
                    'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                    'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'sort_order' => 3,
                'is_active' => 1,
            ],
        ];
    }
}

if (! function_exists('site_default_gallery_items')) {
    function site_default_gallery_items(): array
    {
        return [
            [
                'title' => 'Corona de Porcelana',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'alt_text' => 'Corona de porcelana',
                'sort_order' => 1,
                'is_active' => 1,
            ],
            [
                'title' => 'Puente Fijo',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'alt_text' => 'Puente fijo',
                'sort_order' => 2,
                'is_active' => 1,
            ],
            [
                'title' => 'Corona sobre Implante',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'alt_text' => 'Corona sobre implante',
                'sort_order' => 3,
                'is_active' => 1,
            ],
            [
                'title' => 'Prótesis Removible',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'alt_text' => 'Prótesis removible',
                'sort_order' => 4,
                'is_active' => 1,
            ],
            [
                'title' => 'Restauración Estética',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'alt_text' => 'Restauración estética',
                'sort_order' => 5,
                'is_active' => 1,
            ],
            [
                'title' => 'Proceso de Fabricación',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'alt_text' => 'Proceso de fabricación',
                'sort_order' => 6,
                'is_active' => 1,
            ],
        ];
    }
}

if (! function_exists('site_default_blog_posts')) {
    function site_default_blog_posts(): array
    {
        return [
            [
                'title' => 'Cómo preparar una orden de laboratorio más clara',
                'slug' => 'como-preparar-una-orden-de-laboratorio-mas-clara',
                'content' => '<p>Una orden bien preparada reduce reprocesos, dudas y tiempos muertos. Incluir fecha requerida, indicaciones precisas, selección de piezas y referencias visuales mejora la comunicación entre clínica y laboratorio.</p><p>Cuando el caso incluye materiales, tonos, restauraciones o necesidades estéticas especiales, conviene dejarlo por escrito desde el inicio para facilitar un flujo de trabajo más predecible.</p>',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'is_active' => 1,
            ],
            [
                'title' => 'Ventajas de documentar correctamente el color y el material',
                'slug' => 'ventajas-de-documentar-correctamente-el-color-y-el-material',
                'content' => '<p>Definir color, material y expectativas funcionales desde el inicio ayuda a evitar ajustes innecesarios. Una comunicación clínica más precisa se traduce en entregas más consistentes y mejores resultados estéticos.</p>',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'is_active' => 1,
            ],
            [
                'title' => 'Buenas prácticas para enviar archivos STL al laboratorio',
                'slug' => 'buenas-practicas-para-enviar-archivos-stl-al-laboratorio',
                'content' => '<p>Verificar nombre del caso, integridad del archivo, tipo de restauración y observaciones clínicas antes del envío reduce incidencias. También conviene acompañar el archivo con notas claras sobre contactos, márgenes y objetivos del tratamiento.</p>',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'is_active' => 1,
            ],
        ];
    }
}
