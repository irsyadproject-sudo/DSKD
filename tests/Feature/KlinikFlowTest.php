<?php

namespace Tests\Feature;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use App\Models\Tindakan;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlinikFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    private function makeUser(string $roleName): User
    {
        $roleId = \App\Models\Role::where('name', $roleName)->value('id');

        return User::factory()->create([
            'role_id' => $roleId,
            'email' => $roleName.'@flow.test',
        ]);
    }

    /**
     * Alur utama: pendaftaran -> antrean -> pemeriksaan -> resep -> pembayaran.
     */
    public function test_alur_pelayanan_lengkap_dan_total_pembayaran(): void
    {
        $admin = $this->makeUser('admin');
        $dokterUser = $this->makeUser('dokter');
        $pasienUser = $this->makeUser('pasien');

        $dokter = Dokter::create([
            'user_id' => $dokterUser->id,
            'nama' => 'dr. Test',
            'spesialisasi' => 'Umum',
            'status' => 'aktif',
        ]);

        $pasien = Pasien::create([
            'user_id' => $pasienUser->id,
            'no_rm' => 'RM-2026-00001',
            'nama' => 'Pasien Test',
            'nik' => '3201010101990001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'status' => 'aktif',
        ]);

        $jadwal = JadwalDokter::create([
            'dokter_id' => $dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'ruang' => 'Poli 1',
            'kuota' => 20,
            'aktif' => true,
        ]);

        $tindakan = Tindakan::create(['kode' => 'TDK-1', 'nama' => 'Jasa Dokter', 'tarif' => 100000, 'status' => 'aktif']);
        $obat = Obat::create(['kode' => 'OBT-1', 'nama' => 'Paracetamol', 'satuan' => 'strip', 'stok' => 50, 'stok_minimum' => 5, 'harga' => 10000, 'status' => 'aktif']);

        $this->actingAs($admin)->post(route('pendaftaran.add'), [
            'pasien_id' => $pasien->id,
            'jadwal_dokter_id' => $jadwal->id,
            'tanggal_daftar' => now()->toDateString(),
            'keluhan' => 'Demam',
        ])->assertRedirect(route('pendaftaran.data'));

        $pendaftaran = Pendaftaran::first();
        $antrian = Antrian::where('pendaftaran_id', $pendaftaran->id)->first();
        $this->assertNotNull($antrian);
        $this->assertEquals('menunggu', $antrian->status);

        $this->actingAs($dokterUser)->post(route('pemeriksaan.add', $antrian), [
            'pasien_id' => $pasien->id,
            'tanggal_periksa' => now()->toDateString(),
            'keluhan' => 'Demam',
            'diagnosis' => 'Demam ringan',
            'tindakan_id' => [$tindakan->id],
        ])->assertRedirect(route('pemeriksaan.data'));

        $pemeriksaan = Pemeriksaan::where('pendaftaran_id', $pendaftaran->id)->first();
        $this->assertNotNull($pemeriksaan);
        $this->assertEquals($pendaftaran->id, $pemeriksaan->pendaftaran_id);
        $this->assertEquals('selesai', $antrian->fresh()->status);

        $this->actingAs($dokterUser)->post(route('resep.add'), [
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id,
            'qty' => 2,
            'aturan_pakai' => '3x sehari',
        ])->assertRedirect(route('resep.add'));

        $this->assertEquals(48, $obat->fresh()->stok);

        $this->actingAs($admin)->post(route('pembayaran.add'), [
            'pendaftaran_id' => $pendaftaran->id,
            'metode_pembayaran' => 'tunai',
        ])->assertRedirect(route('pembayaran.data'));

        $pembayaran = Pembayaran::first();
        $this->assertNotNull($pembayaran);
        $this->assertEquals(100000 + (10000 * 2), $pembayaran->total_biaya);
        $this->assertEquals(2, $pembayaran->detailPembayaran->count());

        $this->actingAs($admin)->get(route('pembayaran.cetak', $pembayaran))->assertOk();
        $this->actingAs($dokterUser)->get(route('resep.cetak', $pemeriksaan->resep()->first()))->assertOk();
    }

    public function test_jadwal_yang_bertabrakan_ditolak(): void
    {
        $admin = $this->makeUser('admin');
        $dokterUser = $this->makeUser('dokter');

        $dokter = Dokter::create([
            'user_id' => $dokterUser->id,
            'nama' => 'dr. Test',
            'spesialisasi' => 'Umum',
            'status' => 'aktif',
        ]);

        JadwalDokter::create([
            'dokter_id' => $dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'ruang' => 'Poli 1',
            'kuota' => 20,
            'aktif' => true,
        ]);

        $this->actingAs($admin)->post(route('jadwal.add'), [
            'dokter_id' => $dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'ruang' => 'Poli 2',
            'kuota' => 10,
        ])->assertSessionHasErrors('jam_mulai');

        $this->assertDatabaseCount('jadwal_dokter', 1);
    }

    public function test_jadwal_yang_tidak_bertabrakan_diterima(): void
    {
        $admin = $this->makeUser('admin');
        $dokterUser = $this->makeUser('dokter');

        $dokter = Dokter::create([
            'user_id' => $dokterUser->id,
            'nama' => 'dr. Test',
            'spesialisasi' => 'Umum',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)->post(route('jadwal.add'), [
            'dokter_id' => $dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
            'ruang' => 'Poli 1',
            'kuota' => 20,
        ])->assertRedirect(route('jadwal.data'));

        $this->assertDatabaseCount('jadwal_dokter', 1);
    }
}