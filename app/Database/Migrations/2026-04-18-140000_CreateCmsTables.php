<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCmsTables extends Migration
{
    public function up(): void
    {
        $this->createServicesTable();
        $this->createGalleryItemsTable();
        $this->createSiteSettingsTable();
        $this->createContactMessagesTable();
        $this->seedServices();
        $this->seedGalleryItems();
        $this->seedSiteSettings();
    }

    public function down(): void
    {
        $this->forge->dropTable('contact_messages', true);
        $this->forge->dropTable('site_settings', true);
        $this->forge->dropTable('gallery_items', true);
        $this->forge->dropTable('services', true);
    }

    private function createServicesTable(): void
    {
        if ($this->db->tableExists('services')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 180,
            ],
            'summary' => [
                'type' => 'TEXT',
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug', 'uq_services_slug');
        $this->forge->createTable('services', true);
    }

    private function createGalleryItemsTable(): void
    {
        if ($this->db->tableExists('gallery_items')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 180,
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('gallery_items', true);
    }

    private function createSiteSettingsTable(): void
    {
        if ($this->db->tableExists('site_settings')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('setting_key', 'uq_site_settings_key');
        $this->forge->createTable('site_settings', true);
    }

    private function createContactMessagesTable(): void
    {
        if ($this->db->tableExists('contact_messages')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 140,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 190,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'is_read' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('contact_messages', true);
    }

    private function seedSiteSettings(): void
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $defaults = [
            'contact_phone' => '(33) 3473-5108',
            'contact_phone_href' => '+523334735108',
            'contact_whatsapp' => '(33) 1130-0050',
            'contact_whatsapp_href' => '523311300050',
            'contact_email' => 'contacto@potprotesisdental.com',
            'contact_address' => 'C. Reforma 1752, Ladrón de Guevara, Guadalajara, Jal.',
            'contact_hours' => 'Lun - Vie: 10:00 - 14:00 / 16:00 - 20:00',
            'contact_map_embed_url' => 'https://www.google.com/maps?q=C.%20Reforma%201752%2C%20Ladr%C3%B3n%20de%20Guevara%2C%20Guadalajara%2C%20Jalisco&output=embed',
            'contact_form_recipient_email' => 'contacto@potprotesisdental.com',
        ];

        foreach ($defaults as $key => $value) {
            $exists = $this->db->table('site_settings')->where('setting_key', $key)->countAllResults();

            if ($exists === 0) {
                $this->db->table('site_settings')->insert([
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    private function seedServices(): void
    {
        if (! $this->db->tableExists('services') || $this->db->table('services')->countAllResults() > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $rows = [
            [
                'title' => 'Coronas y Puentes',
                'slug' => 'coronas-y-puentes',
                'summary' => 'Restauraciones fijas en porcelana, zirconia y metal-porcelana con estética natural.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Prótesis Removibles',
                'slug' => 'protesis-removibles',
                'summary' => 'Dentaduras parciales y completas con diseño anatómico y enfoque en comodidad.',
                'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Prótesis sobre Implantes',
                'slug' => 'protesis-sobre-implantes',
                'summary' => 'Soluciones avanzadas con máxima estabilidad, ajuste y precisión milimétrica.',
                'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('services')->insertBatch($rows);
    }

    private function seedGalleryItems(): void
    {
        if (! $this->db->tableExists('gallery_items') || $this->db->table('gallery_items')->countAllResults() > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $rows = [
            ['title' => 'Corona de Porcelana', 'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg', 'alt_text' => 'Corona de porcelana', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Puente Fijo', 'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg', 'alt_text' => 'Puente fijo', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Corona sobre Implante', 'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg', 'alt_text' => 'Corona sobre implante', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Prótesis Removible', 'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg', 'alt_text' => 'Prótesis removible', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Restauración Estética', 'image_path' => 'assets/media/pages-home-gallery-3-94a5fe60.jpg', 'alt_text' => 'Restauración estética', 'sort_order' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Proceso de Fabricación', 'image_path' => 'assets/media/pages-home-gallery-3-e1a8d6f3.jpg', 'alt_text' => 'Proceso de fabricación', 'sort_order' => 6, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        $this->db->table('gallery_items')->insertBatch($rows);
    }
}
