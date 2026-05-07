<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientOrderTestSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');
        $clientEmail = 'dentista.pruebas@pot.local';
        $clientName = 'Dentista Pruebas';

        $client = $this->db->table('clients')
            ->where('email', $clientEmail)
            ->get()
            ->getRowArray();

        if (! $client) {
            $this->db->table('clients')->insert([
                'name' => $clientName,
                'contact_phone' => '3312345678',
                'email' => $clientEmail,
                'password_hash' => password_hash('Pruebas123!', PASSWORD_DEFAULT),
                'email_verified_at' => $now,
                'email_verification_token' => null,
                'email_verification_sent_at' => null,
                'notes' => 'Cuenta de pruebas para captura de órdenes.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $clientId = (int) $this->db->insertID();
        } else {
            $clientId = (int) $client['id'];

            $this->db->table('clients')
                ->where('id', $clientId)
                ->update([
                    'name' => $clientName,
                    'contact_phone' => '3312345678',
                    'password_hash' => password_hash('Pruebas123!', PASSWORD_DEFAULT),
                    'email_verified_at' => $now,
                    'email_verification_token' => null,
                    'email_verification_sent_at' => null,
                    'is_active' => 1,
                    'updated_at' => $now,
                ]);
        }

        $patientName = 'Paciente Pruebas';
        $patient = $this->db->table('patients')
            ->where('client_id', $clientId)
            ->where('name', $patientName)
            ->get()
            ->getRowArray();

        if (! $patient) {
            $this->db->table('patients')->insert([
                'client_id' => $clientId,
                'name' => $patientName,
                'notes' => 'Paciente de pruebas para orden.',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $patientId = (int) $this->db->insertID();
        } else {
            $patientId = (int) $patient['id'];

            $this->db->table('patients')
                ->where('id', $patientId)
                ->update([
                    'notes' => 'Paciente de pruebas para orden.',
                    'is_active' => 1,
                    'updated_at' => $now,
                ]);
        }

        echo "Cliente de prueba: {$clientEmail}\n";
        echo "Password: Pruebas123!\n";
        echo "Client ID: {$clientId}\n";
        echo "Patient ID: {$patientId}\n";
    }
}
