<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * DashboardController
 * Dashboard per role: Admin, Dokter, dan Pasien.
 */
class DashboardController extends Controller
{
    /**
     * Arahkan ke dashboard sesuai role pengguna.
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->admin();
        }

        if ($user->isDokter()) {
            return $this->dokter($user);
        }

        return $this->pasien($user);
    }

    /**
     * Dashboard Admin: statistika pasien, dokter, transaksi, pendaftaran.
     */
    private function admin(): View
    {
        $today = now()->toDateString();

        $data = [
            'total_pasien' => Pasien::count(),
            'total_dokter' => Dokter::count(),
            'pendaftaran_hari_ini' => Pendaftaran::where('tanggal_daftar', $today)->count(),
            'antrian_menunggu' => Antrian::where('tanggal', $today)->where('status', 'menunggu')->count(),
            'total_transaksi' => Pembayaran::where('status', 'lunas')->sum('total_biaya'),
            'pendaftaran_terbaru' => Pendaftaran::with('pasien')->latest()->take(6)->get(),
            'antrian_hari_ini' => Antrian::with('pendaftaran.pasien')->where('tanggal', $today)->orderBy('nomor_antrian')->get(),
        ];

        return view('dashboard.admin', $data);
    }

    /**
     * Dashboard Dokter: jadwal hari ini & antrean periksa.
     */
    private function dokter(User $user): View
    {
        $today = now()->translatedFormat('l');
        Carbon::setLocale('id');

        $dokter = $user->dokter;

        $data = [
            'jadwal_hari_ini' => $dokter
                ? JadwalDokter::where('dokter_id', $dokter->id)->where('hari', $today)->get()
                : collect(),
            'antrian_periksa' => $dokter
                ? Antrian::with('pendaftaran.pasien')
                    ->whereHas('pendaftaran', function ($q) use ($dokter) {
                        $q->whereHas('jadwalDokter', fn ($j) => $j->where('dokter_id', $dokter->id));
                    })
                    ->where('status', '!=', 'selesai')
                    ->where('status', '!=', 'batal')
                    ->where('tanggal', now()->toDateString())
                    ->orderBy('nomor_antrian')
                    ->get()
                : collect(),
        ];

        return view('dashboard.dokter', $data);
    }

    /**
     * Dashboard Pasien: status pendaftaran & riwayat pemeriksaan.
     */
    private function pasien(User $user): View
    {
        $pasien = $user->pasien;

        $data = [
            'pendaftaran' => $pasien
                ? Pendaftaran::with(['jadwalDokter.dokter', 'antrian'])->where('pasien_id', $pasien->id)->latest()->get()
                : collect(),
            'riwayat_pemeriksaan' => $pasien
                ? Pemeriksaan::with('dokter')->where('pasien_id', $pasien->id)->latest()->get()
                : collect(),
        ];

        return view('dashboard.pasien', $data);
    }
}
