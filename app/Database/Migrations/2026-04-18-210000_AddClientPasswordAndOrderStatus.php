<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientPasswordAndOrderStatus extends Migration
{
    public function up(): void
    {
        $this->addClientPasswordHash();
        $this->addOrderStatus();
    }

    public function down(): void
    {
        if ($this->db->tableExists('clients')) {
            $fields = $this->db->getFieldNames('clients');

            if (in_array('password_hash', $fields, true)) {
                $this->forge->dropColumn('clients', 'password_hash');
            }
        }

        if ($this->db->tableExists('lab_orders')) {
            $fields = $this->db->getFieldNames('lab_orders');

            if (in_array('status', $fields, true)) {
                $this->forge->dropColumn('lab_orders', 'status');
            }
        }
    }

    private function addClientPasswordHash(): void
    {
        if (! $this->db->tableExists('clients')) {
            return;
        }

        $fields = $this->db->getFieldNames('clients');

        if (! in_array('password_hash', $fields, true)) {
            $this->forge->addColumn('clients', [
                'password_hash' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'email',
                ],
            ]);
        }
    }

    private function addOrderStatus(): void
    {
        if (! $this->db->tableExists('lab_orders')) {
            return;
        }

        $fields = $this->db->getFieldNames('lab_orders');

        if (! in_array('status', $fields, true)) {
            $this->forge->addColumn('lab_orders', [
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'default' => 'recibida',
                    'after' => 'contact_phone',
                ],
            ]);
        }

        $this->db->table('lab_orders')
            ->where('status IS NULL', null, false)
            ->orWhere('status', '')
            ->update(['status' => 'recibida']);
    }
}
