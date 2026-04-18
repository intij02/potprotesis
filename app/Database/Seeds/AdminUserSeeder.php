<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $username = env('seed.admin.username', 'admin');
        $password = env('seed.admin.password', 'ChangeMe123!');
        $fullName = env('seed.admin.full_name', 'Administrador POT');
        $role     = env('seed.admin.role', 'admin');

        $existing = $this->db->table('admin_users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if ($existing) {
            return;
        }

        $this->db->table('admin_users')->insert([
            'username'      => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'full_name'     => $fullName,
            'role'          => $role,
            'is_active'     => 1,
        ]);
    }
}
