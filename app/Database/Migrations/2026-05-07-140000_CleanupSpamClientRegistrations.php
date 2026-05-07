<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupSpamClientRegistrations extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('clients')) {
            return;
        }

        $threshold = date('Y-m-d H:i:s', time() - 172800);
        $clients = $this->db->table('clients')
            ->select('id, name, email')
            ->where('deleted_at', null)
            ->where('is_active', 0)
            ->where('email_verified_at', null)
            ->where('email_verification_token IS NOT NULL', null, false)
            ->groupStart()
                ->where('email_verification_sent_at <', $threshold)
                ->orWhere('created_at <', $threshold)
                ->orGroupStart()
                    ->where("LOWER(name) LIKE '%http%'", null, false)
                    ->orWhere("LOWER(name) LIKE '%www.%'", null, false)
                    ->orWhere("LOWER(email) LIKE '%.ru'", null, false)
                ->groupEnd()
            ->groupEnd()
            ->get()
            ->getResultArray();

        foreach ($clients as $client) {
            $clientId = (int) ($client['id'] ?? 0);

            if ($clientId <= 0 || $this->hasRelations($clientId)) {
                continue;
            }

            $this->db->table('clients')->where('id', $clientId)->delete();
        }
    }

    public function down(): void
    {
        // Irreversible cleanup migration.
    }

    private function hasRelations(int $clientId): bool
    {
        if ($clientId <= 0) {
            return false;
        }

        $patients = $this->db->table('patients')
            ->select('id')
            ->where('client_id', $clientId)
            ->limit(1)
            ->get()
            ->getFirstRow('array');

        if ($patients !== null) {
            return true;
        }

        if (! $this->db->tableExists('lab_orders')) {
            return false;
        }

        $orders = $this->db->table('lab_orders')
            ->select('id')
            ->where('client_id', $clientId)
            ->limit(1)
            ->get()
            ->getFirstRow('array');

        return $orders !== null;
    }
}
