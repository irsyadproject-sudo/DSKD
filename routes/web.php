<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PasienPortalController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\TindakanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC & AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.store');
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/data', [ProfileController::class, 'updateData'])->name('profile.data');
});

/*
|--------------------------------------------------------------------------
| MODUL 1 - PASIEN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pasien_data', [PasienController::class, 'pasien_data'])->name('pasien.data');
    Route::match(['get', 'post'], 'pasien_add', [PasienController::class, 'pasien_add'])->name('pasien.add');
    Route::match(['get', 'post', 'put'], 'pasien_edit/{pasien}', [PasienController::class, 'pasien_edit'])->name('pasien.edit');
    Route::delete('pasien_hapus/{pasien}', [PasienController::class, 'pasien_hapus'])->name('pasien.hapus');
    Route::get('pasien_cetak/{pasien}', [PasienController::class, 'pasien_cetak'])->name('pasien.cetak');
});

/*
|--------------------------------------------------------------------------
| MODUL 2 - DOKTER (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dokter_data', [DokterController::class, 'dokter_data'])->name('dokter.data');
    Route::match(['get', 'post'], 'dokter_add', [DokterController::class, 'dokter_add'])->name('dokter.add');
    Route::match(['get', 'post', 'put'], 'dokter_edit/{dokter}', [DokterController::class, 'dokter_edit'])->name('dokter.edit');
    Route::delete('dokter_hapus/{dokter}', [DokterController::class, 'dokter_hapus'])->name('dokter.hapus');
    Route::get('dokter_cetak/{dokter}', [DokterController::class, 'dokter_cetak'])->name('dokter.cetak');
});

/*
|--------------------------------------------------------------------------
| MODUL 3 - JADWAL DOKTER (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('jadwal_data', [JadwalDokterController::class, 'jadwal_data'])->name('jadwal.data');
    Route::match(['get', 'post'], 'jadwal_add', [JadwalDokterController::class, 'jadwal_add'])->name('jadwal.add');
    Route::match(['get', 'post', 'put'], 'jadwal_edit/{jadwal}', [JadwalDokterController::class, 'jadwal_edit'])->name('jadwal.edit');
    Route::delete('jadwal_hapus/{jadwal}', [JadwalDokterController::class, 'jadwal_hapus'])->name('jadwal.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 4 - PENDAFTARAN PASIEN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pendaftaran_data', [PendaftaranController::class, 'pendaftaran_data'])->name('pendaftaran.data');
    Route::match(['get', 'post'], 'pendaftaran_add', [PendaftaranController::class, 'pendaftaran_add'])->name('pendaftaran.add');
    Route::match(['get', 'post', 'put'], 'pendaftaran_edit/{pendaftaran}', [PendaftaranController::class, 'pendaftaran_edit'])->name('pendaftaran.edit');
    Route::delete('pendaftaran_hapus/{pendaftaran}', [PendaftaranController::class, 'pendaftaran_hapus'])->name('pendaftaran.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 5 - ANTREAN PASIEN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('antrian_data', [AntrianController::class, 'antrian_data'])->name('antrian.data');
    Route::match(['get', 'post'], 'antrian_add', [AntrianController::class, 'antrian_add'])->name('antrian.add');
    Route::put('antrian_edit/{antrian}', [AntrianController::class, 'antrian_edit'])->name('antrian.edit');
    Route::delete('antrian_hapus/{antrian}', [AntrianController::class, 'antrian_hapus'])->name('antrian.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 8 - TINDAKAN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('tindakan_data', [TindakanController::class, 'tindakan_data'])->name('tindakan.data');
    Route::match(['get', 'post'], 'tindakan_add', [TindakanController::class, 'tindakan_add'])->name('tindakan.add');
    Route::match(['get', 'post', 'put'], 'tindakan_edit/{tindakan}', [TindakanController::class, 'tindakan_edit'])->name('tindakan.edit');
    Route::delete('tindakan_hapus/{tindakan}', [TindakanController::class, 'tindakan_hapus'])->name('tindakan.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 9 - OBAT (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('obat_data', [ObatController::class, 'obat_data'])->name('obat.data');
    Route::match(['get', 'post'], 'obat_add', [ObatController::class, 'obat_add'])->name('obat.add');
    Route::match(['get', 'post', 'put'], 'obat_edit/{obat}', [ObatController::class, 'obat_edit'])->name('obat.edit');
    Route::delete('obat_hapus/{obat}', [ObatController::class, 'obat_hapus'])->name('obat.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 11 - PEMBAYARAN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pembayaran_data', [PembayaranController::class, 'pembayaran_data'])->name('pembayaran.data');
    Route::match(['get', 'post'], 'pembayaran_add', [PembayaranController::class, 'pembayaran_add'])->name('pembayaran.add');
    Route::match(['get', 'post', 'put'], 'pembayaran_edit/{pembayaran}', [PembayaranController::class, 'pembayaran_edit'])->name('pembayaran.edit');
    Route::delete('pembayaran_hapus/{pembayaran}', [PembayaranController::class, 'pembayaran_hapus'])->name('pembayaran.hapus');
    Route::get('pembayaran_cetak/{pembayaran}', [PembayaranController::class, 'pembayaran_cetak'])->name('pembayaran.cetak');
});

/*
|--------------------------------------------------------------------------
| MODUL 12 - LAPORAN (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('laporan_cetak', [LaporanController::class, 'laporan_cetak'])->name('laporan.cetak');
});

/*
|--------------------------------------------------------------------------
| MODUL 6 - PEMERIKSAAN (role: dokter)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('pemeriksaan_data', [PemeriksaanController::class, 'pemeriksaan_data'])->name('pemeriksaan.data');
    Route::match(['get', 'post'], 'pemeriksaan_add/{antrian}', [PemeriksaanController::class, 'pemeriksaan_add'])->name('pemeriksaan.add');
    Route::match(['get', 'post', 'put'], 'pemeriksaan_edit/{pemeriksaan}', [PemeriksaanController::class, 'pemeriksaan_edit'])->name('pemeriksaan.edit');
    Route::delete('pemeriksaan_hapus/{pemeriksaan}', [PemeriksaanController::class, 'pemeriksaan_hapus'])->name('pemeriksaan.hapus');
});

/*
|--------------------------------------------------------------------------
| MODUL 10 - RESEP OBAT (role: dokter)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('resep_data', [ResepController::class, 'resep_data'])->name('resep.data');
    Route::match(['get', 'post'], 'resep_add', [ResepController::class, 'resep_add'])->name('resep.add');
    Route::match(['get', 'post', 'put'], 'resep_edit/{resep}', [ResepController::class, 'resep_edit'])->name('resep.edit');
    Route::delete('resep_hapus/{resep}', [ResepController::class, 'resep_hapus'])->name('resep.hapus');
    Route::get('resep_cetak/{resep}', [ResepController::class, 'resep_cetak'])->name('resep.cetak');
});

/*
|--------------------------------------------------------------------------
| MODUL 7 - REKAM MEDIS (role: dokter & pasien)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dokter,pasien'])->group(function () {
    Route::get('rekam_medis_data', [RekamMedisController::class, 'rekam_medis_data'])->name('rekam_medis.data');
    Route::get('rekam_medis_detail/{pemeriksaan}', [RekamMedisController::class, 'rekam_medis_detail'])->name('rekam_medis.detail');
});

/*
|--------------------------------------------------------------------------
| ROUTES PORTAL PASIEN (role: pasien)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pasien'])->prefix('portal')->name('pasien.portal.')->group(function () {
    Route::get('pendaftaran', [PasienPortalController::class, 'pendaftaran'])->name('pendaftaran');
    Route::post('pendaftaran', [PasienPortalController::class, 'daftar']);
    Route::get('status', [PasienPortalController::class, 'status'])->name('status');
    Route::get('riwayat', [PasienPortalController::class, 'riwayat'])->name('riwayat');
    Route::get('antrian/refresh', [PasienPortalController::class, 'antrianRefresh'])->name('antrian.refresh');
});