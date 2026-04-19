<?php

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

if (! function_exists('site_default_services')) {
    function site_default_services(): array
    {
        return [
            [
                'title' => 'Coronas y Puentes',
                'slug' => 'coronas-y-puentes',
                'summary' => 'Restauraciones fijas en porcelana, zirconia y metal-porcelana con estética natural.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'sort_order' => 1,
                'is_active' => 1,
            ],
            [
                'title' => 'Prótesis Removibles',
                'slug' => 'protesis-removibles',
                'summary' => 'Dentaduras parciales y completas con diseño anatómico y enfoque en comodidad.',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'sort_order' => 2,
                'is_active' => 1,
            ],
            [
                'title' => 'Prótesis sobre Implantes',
                'slug' => 'protesis-sobre-implantes',
                'summary' => 'Soluciones avanzadas con máxima estabilidad, ajuste y precisión milimétrica.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
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
