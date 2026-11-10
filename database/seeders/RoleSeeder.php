<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed data awal role pengguna Sistem Informasi Klinik.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Admin / Petugas'],
            ['name' => 'dokter', 'display_name' => 'Dokter'],
            ['name' => 'pasien', 'display_name' => 'Pasien'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
