<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsAndSoftDeletes extends Migration
{
    public function up(): void
    {
        $this->addAuditFields('lab_orders');
        $this->addAuditFields('admin_users');
    }

    public function down(): void
    {
        $this->dropAuditFields('lab_orders');
        $this->dropAuditFields('admin_users');
    }

    private function addAuditFields(string $table): void
    {
        $fields = $this->db->getFieldNames($table);
        $columns = [];

        if (! in_array('updated_at', $fields, true)) {
            $columns['updated_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ];
        }

        if (! in_array('deleted_at', $fields, true)) {
            $columns['deleted_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at',
            ];
        }

        if ($columns !== []) {
            $this->forge->addColumn($table, $columns);
        }

        if (in_array('created_at', $fields, true) && in_array('updated_at', $this->db->getFieldNames($table), true)) {
            $this->db->query("UPDATE {$table} SET updated_at = created_at WHERE updated_at IS NULL AND created_at IS NOT NULL");
        }
    }

    private function dropAuditFields(string $table): void
    {
        $fields = $this->db->getFieldNames($table);

        if (in_array('deleted_at', $fields, true)) {
            $this->forge->dropColumn($table, 'deleted_at');
        }

        $fields = $this->db->getFieldNames($table);

        if (in_array('updated_at', $fields, true)) {
            $this->forge->dropColumn($table, 'updated_at');
        }
    }
}
