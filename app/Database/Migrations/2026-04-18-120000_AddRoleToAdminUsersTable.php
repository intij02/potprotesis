<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToAdminUsersTable extends Migration
{
    public function up(): void
    {
        $fields = $this->db->getFieldNames('admin_users');

        if (! in_array('role', $fields, true)) {
            $this->forge->addColumn('admin_users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'admin',
                    'after'      => 'full_name',
                ],
            ]);
        }

        $this->db->query("UPDATE admin_users SET role = 'admin' WHERE role IS NULL OR role = ''");
    }

    public function down(): void
    {
        $fields = $this->db->getFieldNames('admin_users');

        if (in_array('role', $fields, true)) {
            $this->forge->dropColumn('admin_users', 'role');
        }
    }
}
