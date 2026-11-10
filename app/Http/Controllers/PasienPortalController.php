<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasienPortalController extends Controller
{
    /**
     * Form pendaftaran mandiri pasien.
     */
    public function pendaftaran(): View
    {
        $jadwal = JadwalDokter::with('dokter')->where('aktif', true)->get();

        return view('pasien_portal.pendaftaran', compact('jadwal'));
    }

    /**
     * Proses pendaftaran mandiri pasien.
     */
    public function daftar(Request $request): RedirectResponse
    {
        $pasien = auth()->user()->pasien;

        if (!$pasien) {
            return redirect()->route('pasien.portal.pendaftaran')->withErrors(['Alamat' => 'Akun Anda belum terhubung ke data pasien.']);
        }

        $data = $request->validate([
            'jadwal_dokter_id' => ['required', 'exists:jadwal_dokter,id'],
            'tanggal_daftar' => ['required', 'date', 'after_or_equal:today'],
            'keluhan' => ['required', 'string'],
        ]);

        $jadwal = JadwalDokter::findOrFail($data['jadwal_dokter_id']);
        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        if ($namaHari[\Carbon\Carbon::parse($data['tanggal_daftar'])->dayOfWeek] !== $jadwal->hari) {
            return back()
                ->withErrors(['tanggal_daftar' => "Tanggal daftar harus hari {$jadwal->hari} sesuai jadwal praktik dokter."])
                ->withInput();
        }

        $pendaftaran = Pendaftaran::create([
            'no_pendaftaran' => 'PND-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'pasien_id' => $pasien->id,
            'jadwal_dokter_id' => $data['jadwal_dokter_id'],
            'tanggal_daftar' => $data['tanggal_daftar'],
            'keluhan' => $data['keluhan'],
            'status' => 'terdaftar',
        ]);

        $antrianCount = Antrian::where('tanggal', $data['tanggal_daftar'])->count() + 1;

        Antrian::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nomor_antrian' => str_pad((string) $antrianCount, 3, '0', STR_PAD_LEFT),
            'tanggal' => $data['tanggal_daftar'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('pasien.portal.status')->with('success', 'Pendaftaran berhasil. Cek nomor antrean Anda.');
    }

    /**
     * Halaman informasi nomor antrean aktif pasien.
     */
    public function status(): View
    {
        $pasien = auth()->user()->pasien;

        $antrian = $pasien
            ? Antrian::with('pendaftaran')
                ->whereHas('pendaftaran', fn ($q) => $q->where('pasien_id', $pasien->id))
                ->whereDate('tanggal', now()->toDateString())
                ->latest()
                ->first()
            : null;

        return view('pasien_portal.status_antrian', compact('antrian'));
    }

    /**
     * Riwayat rekam medis & biaya pasien.
     */
    public function riwayat(): View
    {
        $pasien = auth()->user()->pasien;

        $pemeriksaan = $pasien
            ? Pemeriksaan::with(['dokter', 'pemeriksaanTindakan.tindakan', 'resep.detailResep.obat'])
                ->where('pasien_id', $pasien->id)
                ->latest()
                ->get()
            : collect();

        return view('pasien_portal.riwayat', compact('pemeriksaan'));
    }

    /**
     * Data JSON status antrean pasien secara real-time (untuk dashboard).
     */
    public function antrianRefresh(Request $request)
    {
        $pasien = auth()->user()->pasien;

        if (!$pasien) {
            return response()->json(['found' => false, 'error' => 'Data pasien tidak ditemukan.'], 404);
        }

        $antrian = Antrian::with(['pendaftaran.jadwalDokter.dokter'])
            ->whereHas('pendaftaran', fn ($q) => $q->where('pasien_id', $pasien->id))
            ->whereDate('tanggal', now()->toDateString())
            ->latest()
            ->first();

        if (!$antrian) {
            return response()->json(['found' => false]);
        }

        $status = $antrian->status;
        $map = ['menunggu' => 'Menunggu', 'dipanggil' => 'Dipanggil', 'diperiksa' => 'Diperiksa', 'selesai' => 'Selesai', 'batal' => 'Batal'];

        $sisa = 0;
        if ($status === 'menunggu') {
            $jadwalId = $antrian->pendaftaran?->jadwal_dokter_id;
            $sisa = Antrian::where('tanggal', $antrian->tanggal->toDateString())
                ->where('pendaftaran_id', '!=', $antrian->pendaftaran_id)
                ->whereHas('pendaftaran', fn ($q) => $q->where('jadwal_dokter_id', $jadwalId))
                ->where('status', 'menunggu')
                ->where('nomor_antrian', '<', $antrian->nomor_antrian)
                ->count();
        }

        return response()->json([
            'found' => true,
            'antrian' => [
                'nomor_antrian' => $antrian->nomor_antrian,
                'tanggal' => $antrian->tanggal?->format('d-m-Y'),
                'status' => $status,
                'status_label' => $map[$status] ?? $status,
                'sisa' => $sisa,
                'dokter' => $antrian->pendaftaran?->jadwalDokter?->dokter?->nama ?? '-',
                'ruang' => $antrian->pendaftaran?->jadwalDokter?->ruang ?? '-',
            ],
            'server_time' => now()->format('H:i:s'),
        ]);
    }
}
