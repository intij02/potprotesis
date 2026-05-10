<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderEditLogsTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('order_edit_logs')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'admin_user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'admin_username' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
            ],
            'admin_full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'observations' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');
        $this->forge->addKey('admin_user_id');
        $this->forge->createTable('order_edit_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('order_edit_logs', true);
    }
}
