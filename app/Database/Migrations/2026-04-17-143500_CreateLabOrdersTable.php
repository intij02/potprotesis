<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLabOrdersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'sent_date' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'required_date' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'dentist_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'patient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'contact_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'shade' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'work_types' => [
                'type' => 'JSON',
            ],
            'selected_teeth' => [
                'type' => 'JSON',
            ],
            'restoration_types' => [
                'type' => 'JSON',
            ],
            'implant_case' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
            ],
            'implant_chimney' => [
                'type'       => 'VARCHAR',
                'constraint' => 12,
                'default'    => 'none',
            ],
            'observations' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'signature_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
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
        $this->forge->createTable('lab_orders', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('lab_orders', true);
    }
}
