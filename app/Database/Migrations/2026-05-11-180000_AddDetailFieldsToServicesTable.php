<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDetailFieldsToServicesTable extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('services')) {
            return;
        }

        $fields = $this->db->getFieldNames('services');

        if (! in_array('detail_content', $fields, true)) {
            $this->forge->addColumn('services', [
                'detail_content' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'summary',
                ],
            ]);
        }

        $fields = $this->db->getFieldNames('services');

        if (! in_array('detail_images', $fields, true)) {
            $this->forge->addColumn('services', [
                'detail_images' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'image_path',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('services')) {
            return;
        }

        $fields = $this->db->getFieldNames('services');

        if (in_array('detail_images', $fields, true)) {
            $this->forge->dropColumn('services', 'detail_images');
        }

        $fields = $this->db->getFieldNames('services');

        if (in_array('detail_content', $fields, true)) {
            $this->forge->dropColumn('services', 'detail_content');
        }
    }
}
