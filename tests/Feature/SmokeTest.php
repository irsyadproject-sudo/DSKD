<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    private function makeUser(string $roleName): User
    {
        $roleId = Role::where('name', $roleName)->value('id');

        return User::factory()->create([
            'role_id' => $roleId,
            'email' => $roleName.'@klinik.test',
        ]);
    }

    public function test_guest_pages_render(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/login')->assertOk();
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_admin_pages_render(): void
    {
        $user = $this->makeUser('admin');

        $pages = [
            'dashboard',
            'pasien.data',
            'pasien.add',
            'dokter.data',
            'dokter.add',
            'jadwal.data',
            'jadwal.add',
            'tindakan.data',
            'obat.data',
            'obat.add',
            'pendaftaran.data',
            'pendaftaran.add',
            'antrian.data',
            'pembayaran.data',
            'pembayaran.add',
            'laporan.cetak',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($user)->get(route($page));
            $this->assertTrue(
                $response->status() === 200,
                "Route [{$page}] returned {$response->status()}"
            );
        }
    }

    public function test_dokter_pages_render(): void
    {
        $user = $this->makeUser('dokter');
        $dokter = Dokter::create([
            'user_id' => $user->id,
            'nama' => 'dr. Contoh',
            'spesialisasi' => 'Umum',
            'status' => 'aktif',
        ]);

        $pages = [
            'dashboard',
            'pemeriksaan.data',
            'resep.data',
            'resep.add',
            'rekam_medis.data',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($user)->get(route($page));
            $this->assertTrue(
                $response->status() === 200,
                "Route [{$page}] returned {$response->status()}"
            );
        }
    }

    public function test_pasien_pages_render(): void
    {
        $user = $this->makeUser('pasien');
        Pasien::create([
            'user_id' => $user->id,
            'no_rm' => 'RM-2026-00001',
            'nama' => 'Pasien Contoh',
            'nik' => '3201010101990001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'status' => 'aktif',
        ]);

        $pages = [
            'dashboard',
            'pasien.portal.pendaftaran',
            'pasien.portal.status',
            'pasien.portal.riwayat',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($user)->get(route($page));
            $this->assertTrue(
                $response->status() === 200,
                "Route [{$page}] returned {$response->status()}"
            );
        }
    }

    public function test_role_access_control(): void
    {
        $pasien = $this->makeUser('pasien');
        $dokter = $this->makeUser('dokter');
        $admin = $this->makeUser('admin');

        $this->actingAs($pasien)->get(route('pasien.data'))->assertForbidden();
        $this->actingAs($pasien)->get(route('pemeriksaan.data'))->assertForbidden();

        $this->actingAs($dokter)->get(route('pasien.data'))->assertForbidden();
        $this->actingAs($dokter)->get(route('laporan.cetak'))->assertForbidden();

        $this->actingAs($admin)->get(route('pemeriksaan.data'))->assertForbidden();
        $this->actingAs($admin)->get(route('resep.data'))->assertForbidden();
    }
}