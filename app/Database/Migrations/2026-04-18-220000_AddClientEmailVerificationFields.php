<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientEmailVerificationFields extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('clients')) {
            return;
        }

        $fields = $this->db->getFieldNames('clients');
        $columns = [];

        if (! in_array('email_verification_token', $fields, true)) {
            $columns['email_verification_token'] = [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
                'after' => 'password_hash',
            ];
        }

        if (! in_array('email_verification_sent_at', $fields, true)) {
            $columns['email_verification_sent_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verification_token',
            ];
        }

        if (! in_array('email_verified_at', $fields, true)) {
            $columns['email_verified_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verification_sent_at',
            ];
        }

        if ($columns !== []) {
            $this->forge->addColumn('clients', $columns);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('clients')) {
            return;
        }

        $fields = $this->db->getFieldNames('clients');

        foreach (['email_verified_at', 'email_verification_sent_at', 'email_verification_token'] as $field) {
            if (in_array($field, $fields, true)) {
                $this->forge->dropColumn('clients', $field);
            }
        }
    }
}
