<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan riwayat rekam medis pasien.
     * Dokter melihat semua; Pasien hanya punyanya sendiri.
     */
    public function rekam_medis_data(): View
    {
        $user = auth()->user();

        if ($user->isPasien()) {
            $pasien = $user->pasien;
            $pemeriksaan = $pasien
                ? Pemeriksaan::with('dokter')->where('pasien_id', $pasien->id)->latest()->get()
                : collect();
        } else {
            $dokter = $user->dokter;
            $pemeriksaan = $dokter
                ? Pemeriksaan::with(['pasien', 'dokter'])->where('dokter_id', $dokter->id)->latest()->get()
                : collect();
        }

        return view('rekam_medis.index', compact('pemeriksaan'));
    }

    /**
     * Menampilkan rincian detail rekam medis pasien.
     */
    public function rekam_medis_detail(Pemeriksaan $pemeriksaan): View
    {
        $user = auth()->user();

        if ($user->isPasien()) {
            $pasien = $user->pasien;
            if (!$pasien || (int) $pemeriksaan->pasien_id !== (int) $pasien->id) {
                abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
            }
        }

        $pemeriksaan->load([
            'pasien',
            'dokter',
            'pemeriksaanTindakan.tindakan',
            'resep.detailResep.obat',
        ]);

        return view('rekam_medis.detail', compact('pemeriksaan'));
    }
}