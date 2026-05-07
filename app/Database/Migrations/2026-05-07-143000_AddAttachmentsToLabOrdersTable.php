<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAttachmentsToLabOrdersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('lab_orders', [
            'attachments' => [
                'type' => 'JSON',
                'null' => true,
                'after' => 'implant_chimney',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('lab_orders', 'attachments');
    }
}
