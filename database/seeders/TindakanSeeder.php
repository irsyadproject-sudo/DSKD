<?php

namespace Database\Seeders;

use App\Models\Tindakan;
use Illuminate\Database\Seeder;

class TindakanSeeder extends Seeder
{
    /**
     * Seed data master jenis tindakan dan tarif.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'TD-001', 'nama' => 'Konsultasi Dokter Umum', 'tarif' => 150000],
            ['kode' => 'TD-002', 'nama' => 'Pemeriksaan Tekanan Darah', 'tarif' => 25000],
            ['kode' => 'TD-003', 'nama' => 'Pemeriksaan Gula Darah', 'tarif' => 40000],
            ['kode' => 'TD-004', 'nama' => 'Cek Kolesterol', 'tarif' => 50000],
            ['kode' => 'TD-005', 'nama' => 'Injeksi / Suntik', 'tarif' => 30000],
            ['kode' => 'TD-006', 'nama' => 'Pemasangan Infus', 'tarif' => 75000],
            ['kode' => 'TD-007', 'nama' => 'Pemeriksaan USG Ringan', 'tarif' => 200000],
            ['kode' => 'TD-008', 'nama' => 'Perawatan Luka', 'tarif' => 60000],
            ['kode' => 'TD-009', 'nama' => 'Pemeriksaan Laboratorium Sederhana', 'tarif' => 100000],
            ['kode' => 'TD-010', 'nama' => 'Konsultasi Dokter Spesialis', 'tarif' => 250000],
        ];

        foreach ($data as $item) {
            Tindakan::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'tarif' => $item['tarif'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
