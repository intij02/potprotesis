<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsPatientsAndLinkOrders extends Migration
{
    public function up(): void
    {
        $this->createClientsTable();
        $this->createPatientsTable();
        $this->addOrderColumns();
        $this->backfillOrderRelations();
    }

    public function down(): void
    {
        if ($this->db->tableExists('lab_orders')) {
            $fields = $this->db->getFieldNames('lab_orders');

            if (in_array('client_id', $fields, true)) {
                $this->forge->dropColumn('lab_orders', 'client_id');
            }

            if (in_array('patient_id', $fields, true)) {
                $this->forge->dropColumn('lab_orders', 'patient_id');
            }
        }

        $this->forge->dropTable('patients', true);
        $this->forge->dropTable('clients', true);
    }

    private function createClientsTable(): void
    {
        if ($this->db->tableExists('clients')) {
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
                'constraint' => 160,
            ],
            'contact_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 190,
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->createTable('clients', true);
    }

    private function createPatientsTable(): void
    {
        if ($this->db->tableExists('patients')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('client_id');
        $this->forge->createTable('patients', true);
    }

    private function addOrderColumns(): void
    {
        if (! $this->db->tableExists('lab_orders')) {
            return;
        }

        $fields = $this->db->getFieldNames('lab_orders');
        $columns = [];

        if (! in_array('client_id', $fields, true)) {
            $columns['client_id'] = [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'required_date',
            ];
        }

        if (! in_array('patient_id', $fields, true)) {
            $columns['patient_id'] = [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'client_id',
            ];
        }

        if ($columns !== []) {
            $this->forge->addColumn('lab_orders', $columns);
        }
    }

    private function backfillOrderRelations(): void
    {
        if (! $this->db->tableExists('lab_orders')) {
            return;
        }

        $orders = $this->db->table('lab_orders')->get()->getResultArray();

        if ($orders === []) {
            return;
        }

        $clientMap = [];
        $patientMap = [];
        $now = date('Y-m-d H:i:s');

        foreach ($this->db->table('clients')->get()->getResultArray() as $client) {
            $clientMap[$this->clientKey($client['name'] ?? '', $client['contact_phone'] ?? '')] = (int) $client['id'];
        }

        foreach ($this->db->table('patients')->get()->getResultArray() as $patient) {
            $patientMap[$this->patientKey((int) ($patient['client_id'] ?? 0), $patient['name'] ?? '')] = (int) $patient['id'];
        }

        foreach ($orders as $order) {
            $clientId = isset($order['client_id']) ? (int) $order['client_id'] : 0;
            $patientId = isset($order['patient_id']) ? (int) $order['patient_id'] : 0;

            if ($clientId <= 0 && trim((string) ($order['dentist_name'] ?? '')) !== '') {
                $clientKey = $this->clientKey((string) $order['dentist_name'], (string) ($order['contact_phone'] ?? ''));

                if (! isset($clientMap[$clientKey])) {
                    $this->db->table('clients')->insert([
                        'name' => trim((string) $order['dentist_name']),
                        'contact_phone' => trim((string) ($order['contact_phone'] ?? '')) ?: null,
                        'is_active' => 1,
                        'created_at' => $order['created_at'] ?? $now,
                        'updated_at' => $order['updated_at'] ?? ($order['created_at'] ?? $now),
                    ]);
                    $clientMap[$clientKey] = (int) $this->db->insertID();
                }

                $clientId = $clientMap[$clientKey];
            }

            if ($clientId > 0 && $patientId <= 0 && trim((string) ($order['patient_name'] ?? '')) !== '') {
                $patientKey = $this->patientKey($clientId, (string) $order['patient_name']);

                if (! isset($patientMap[$patientKey])) {
                    $this->db->table('patients')->insert([
                        'client_id' => $clientId,
                        'name' => trim((string) $order['patient_name']),
                        'is_active' => 1,
                        'created_at' => $order['created_at'] ?? $now,
                        'updated_at' => $order['updated_at'] ?? ($order['created_at'] ?? $now),
                    ]);
                    $patientMap[$patientKey] = (int) $this->db->insertID();
                }

                $patientId = $patientMap[$patientKey];
            }

            if ($clientId > 0 || $patientId > 0) {
                $this->db->table('lab_orders')
                    ->where('id', $order['id'])
                    ->update([
                        'client_id' => $clientId > 0 ? $clientId : null,
                        'patient_id' => $patientId > 0 ? $patientId : null,
                    ]);
            }
        }
    }

    private function clientKey(string $name, string $phone): string
    {
        return $this->normalize($name) . '|' . preg_replace('/\D+/', '', $phone);
    }

    private function patientKey(int $clientId, string $name): string
    {
        return $clientId . '|' . $this->normalize($name);
    }

    private function normalize(string $value): string
    {
        $value = trim($value);

        if (function_exists('mb_strtolower')) {
            return mb_strtolower($value, 'UTF-8');
        }

        return strtolower($value);
    }
}
