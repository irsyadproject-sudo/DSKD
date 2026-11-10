<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    /**
     * Seed data jadwal praktik dokter.
     */
    public function run(): void
    {
        $dokterId = Dokter::where('spesialisasi', 'Umum')->value('id');

        if (!$dokterId) {
            $this->command?->warn('Seeder JadwalDokter di-skip: belum ada data dokter.');
            return;
        }

        $data = [
            ['hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 1', 'kuota' => 20],
            ['hari' => 'Senin', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'ruang' => 'Poli Umum 1', 'kuota' => 15],
            ['hari' => 'Selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 1', 'kuota' => 20],
            ['hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 2', 'kuota' => 20],
            ['hari' => 'Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 1', 'kuota' => 20],
            ['hari' => 'Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 1', 'kuota' => 20],
            ['hari' => 'Sabtu', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'ruang' => 'Poli Umum 1', 'kuota' => 15],
        ];

        foreach ($data as $item) {
            JadwalDokter::updateOrCreate(
                [
                    'dokter_id' => $dokterId,
                    'hari' => $item['hari'],
                    'jam_mulai' => $item['jam_mulai'],
                ],
                [
                    'jam_selesai' => $item['jam_selesai'],
                    'ruang' => $item['ruang'],
                    'kuota' => $item['kuota'],
                    'aktif' => true,
                ]
            );
        }
    }
}
