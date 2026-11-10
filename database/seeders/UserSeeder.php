<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed akun Sistem Informasi Klinik:
     * 3 Admin, 5 Dokter, dan 10 Pasien.
     */
    public function run(): void
    {
        $roleId = fn (string $name) => Role::where('name', $name)->value('id');

        /*
        |--------------------------------------------------------------------------
        | ADMIN (3)
        |--------------------------------------------------------------------------
        */
        $admins = [
            ['email' => 'admin@klinik.test', 'name' => 'Administrator'],
            ['email' => 'admin2@klinik.test', 'name' => 'Rina Marlina'],
            ['email' => 'kasir@klinik.test', 'name' => 'Dedi Kurniawan'],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $roleId('admin'),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DOKTER (5)
        |--------------------------------------------------------------------------
        */
        $dokters = [
            [
                'email' => 'dokter@klinik.test',
                'name' => 'dr. Siti Rahayu',
                'no_sip' => 'SIP-2026-0001',
                'spesialisasi' => 'Umum',
                'no_hp' => '0812-1111-1111',
                'tarif_konsultasi' => 150000,
            ],
            [
                'email' => 'dr.budi@klinik.test',
                'name' => 'dr. Budi Pramono',
                'no_sip' => 'SIP-2026-0002',
                'spesialisasi' => 'Anak',
                'no_hp' => '0812-1111-1112',
                'tarif_konsultasi' => 160000,
            ],
            [
                'email' => 'dr.dewi@klinik.test',
                'name' => 'dr. Dewi Anggraini',
                'no_sip' => 'SIP-2026-0003',
                'spesialisasi' => 'Gigi',
                'no_hp' => '0812-1111-1113',
                'tarif_konsultasi' => 120000,
            ],
            [
                'email' => 'dr.ahmad@klinik.test',
                'name' => 'dr. Ahmad Fauzi',
                'no_sip' => 'SIP-2026-0004',
                'spesialisasi' => 'Penyakit Dalam',
                'no_hp' => '0812-1111-1114',
                'tarif_konsultasi' => 175000,
            ],
            [
                'email' => 'dr.rina@klinik.test',
                'name' => 'dr. Rina Kusuma',
                'no_sip' => 'SIP-2026-0005',
                'spesialisasi' => 'Kulit & Kelamin',
                'no_hp' => '0812-1111-1115',
                'tarif_konsultasi' => 140000,
            ],
        ];

        foreach ($dokters as $dokter) {
            $user = User::updateOrCreate(
                ['email' => $dokter['email']],
                [
                    'name' => $dokter['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $roleId('dokter'),
                ]
            );

            Dokter::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $dokter['name'],
                    'no_sip' => $dokter['no_sip'],
                    'spesialisasi' => $dokter['spesialisasi'],
                    'no_hp' => $dokter['no_hp'],
                    'email' => $dokter['email'],
                    'tarif_konsultasi' => $dokter['tarif_konsultasi'],
                    'status' => 'aktif',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PASIEN (10)
        |--------------------------------------------------------------------------
        */
        $pasiens = [
            [
                'email' => 'pasien@klinik.test',
                'name' => 'Budi Santoso',
                'nik' => '3201010101990001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1990-01-01',
                'alamat' => 'Jl. Contoh No. 1, Bandung',
                'no_hp' => '0812-2222-2222',
                'golongan_darah' => 'O',
            ],
            [
                'email' => 'pasien.sari@klinik.test',
                'name' => 'Sari Wulandari',
                'nik' => '3201014507980002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1998-07-05',
                'alamat' => 'Jl. Melati No. 2, Bandung',
                'no_hp' => '0812-2222-2223',
                'golongan_darah' => 'A',
            ],
            [
                'email' => 'pasien.andi@klinik.test',
                'name' => 'Andi Prasetyo',
                'nik' => '3201011203950003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-03-12',
                'alamat' => 'Jl. Anggrek No. 3, Bandung',
                'no_hp' => '0812-2222-2224',
                'golongan_darah' => 'B',
            ],
            [
                'email' => 'pasien.dewi@klinik.test',
                'name' => 'Dewi Lestari',
                'nik' => '3201012302900004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-02-23',
                'alamat' => 'Jl. Kenanga No. 4, Bandung',
                'no_hp' => '0812-2222-2225',
                'golongan_darah' => 'AB',
            ],
            [
                'email' => 'pasien.bambang@klinik.test',
                'name' => 'Bambang Sutrisno',
                'nik' => '3201010805880005',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1988-05-08',
                'alamat' => 'Jl. Mawar No. 5, Bandung',
                'no_hp' => '0812-2222-2226',
                'golongan_darah' => 'O',
            ],
            [
                'email' => 'pasien.maya@klinik.test',
                'name' => 'Maya Anggraini',
                'nik' => '3201013012000006',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2000-12-30',
                'alamat' => 'Jl. Cempaka No. 6, Bandung',
                'no_hp' => '0812-2222-2227',
                'golongan_darah' => 'A',
            ],
            [
                'email' => 'pasien.reza@klinik.test',
                'name' => 'Reza Maulana',
                'nik' => '3201011609940007',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1994-09-16',
                'alamat' => 'Jl. Flamboyan No. 7, Bandung',
                'no_hp' => '0812-2222-2228',
                'golongan_darah' => 'B',
            ],
            [
                'email' => 'pasien.intan@klinik.test',
                'name' => 'Intan Permatasari',
                'nik' => '3201010506880008',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1988-06-05',
                'alamat' => 'Jl. Dahlia No. 8, Bandung',
                'no_hp' => '0812-2222-2229',
                'golongan_darah' => 'O',
            ],
            [
                'email' => 'pasien.hendra@klinik.test',
                'name' => 'Hendra Gunawan',
                'nik' => '3201011711830009',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1983-11-17',
                'alamat' => 'Jl. Teratai No. 9, Bandung',
                'no_hp' => '0812-2222-2230',
                'golongan_darah' => 'AB',
            ],
            [
                'email' => 'pasien.lina@klinik.test',
                'name' => 'Lina Marlina',
                'nik' => '3201012505010010',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2001-05-25',
                'alamat' => 'Jl. Bougenville No. 10, Bandung',
                'no_hp' => '0812-2222-2231',
                'golongan_darah' => 'A',
            ],
        ];

        foreach ($pasiens as $index => $pasien) {
            $user = User::updateOrCreate(
                ['email' => $pasien['email']],
                [
                    'name' => $pasien['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $roleId('pasien'),
                ]
            );

            Pasien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_rm' => 'RM-' . now()->format('Y') . '-' . Str::padLeft($index + 1, 5, '0'),
                    'nama' => $pasien['name'],
                    'nik' => $pasien['nik'],
                    'jenis_kelamin' => $pasien['jenis_kelamin'],
                    'tanggal_lahir' => $pasien['tanggal_lahir'],
                    'alamat' => $pasien['alamat'],
                    'no_hp' => $pasien['no_hp'],
                    'golongan_darah' => $pasien['golongan_darah'],
                    'status' => 'aktif',
                ]
            );
        }

        $this->command?->info('Akun Sistem Informasi Klinik (password default: password)');
        $this->command?->info('  Admin  : 3 akun (admin, admin2, kasir @klinik.test)');
        $this->command?->info('  Dokter : 5 akun (dokter, dr.budi, dr.dewi, dr.ahmad, dr.rina @klinik.test)');
        $this->command?->info('  Pasien : 10 akun (pasien, pasien.sari, pasien.andi, ... @klinik.test)');
    }
}