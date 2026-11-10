<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Seed data master obat, stok, harga, dan kedaluwarsa.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'OB-001', 'nama' => 'Paracetamol 500mg', 'satuan' => 'strip', 'stok' => 200, 'stok_minimum' => 20, 'harga' => 15000, 'tanggal_kedaluwarsa' => '2028-01-01'],
            ['kode' => 'OB-002', 'nama' => 'Amoxicillin 500mg', 'satuan' => 'strip', 'stok' => 150, 'stok_minimum' => 20, 'harga' => 20000, 'tanggal_kedaluwarsa' => '2028-02-01'],
            ['kode' => 'OB-003', 'nama' => 'Ibuprofen 400mg', 'satuan' => 'strip', 'stok' => 120, 'stok_minimum' => 15, 'harga' => 18000, 'tanggal_kedaluwarsa' => '2028-03-01'],
            ['kode' => 'OB-004', 'nama' => 'Vitamin C 1000mg', 'satuan' => 'botol', 'stok' => 80, 'stok_minimum' => 10, 'harga' => 45000, 'tanggal_kedaluwarsa' => '2028-06-01'],
            ['kode' => 'OB-005', 'nama' => 'Antasida DOEN', 'satuan' => 'strip', 'stok' => 100, 'stok_minimum' => 15, 'harga' => 12000, 'tanggal_kedaluwarsa' => '2027-12-01'],
            ['kode' => 'OB-006', 'nama' => 'Salbutamol (Inhaler)', 'satuan' => 'pcs', 'stok' => 40, 'stok_minimum' => 5, 'harga' => 95000, 'tanggal_kedaluwarsa' => '2027-11-01'],
            ['kode' => 'OB-007', 'nama' => 'Methylprednisolone 4mg', 'satuan' => 'strip', 'stok' => 60, 'stok_minimum' => 10, 'harga' => 22000, 'tanggal_kedaluwarsa' => '2028-04-01'],
            ['kode' => 'OB-008', 'nama' => 'Salep Hirup / Balsem', 'satuan' => 'tube', 'stok' => 70, 'stok_minimum' => 10, 'harga' => 25000, 'tanggal_kedaluwarsa' => '2028-05-01'],
        ];

        foreach ($data as $item) {
            Obat::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'satuan' => $item['satuan'],
                    'stok' => $item['stok'],
                    'stok_minimum' => $item['stok_minimum'],
                    'harga' => $item['harga'],
                    'tanggal_kedaluwarsa' => $item['tanggal_kedaluwarsa'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
