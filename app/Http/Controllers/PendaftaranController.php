<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan data pendaftaran.
     */
    public function pendaftaran_data(): View
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'jadwalDokter.dokter', 'antrian'])
            ->latest()
            ->paginate(15);

        return view('pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Menambah pendaftaran baru (sekaligus terbitkan antrean).
     * GET -> tampilkan form, POST -> simpan.
     */
    public function pendaftaran_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $pasien = Pasien::where('status', 'aktif')->get();
            $jadwal = JadwalDokter::with('dokter')->where('aktif', true)->get();

            return view('pendaftaran.create', compact('pasien', 'jadwal'));
        }

        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'jadwal_dokter_id' => ['required', 'exists:jadwal_dokter,id'],
            'tanggal_daftar' => ['required', 'date'],
            'keluhan' => ['required', 'string'],
        ]);

        $data['no_pendaftaran'] = 'PND-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        $data['status'] = 'terdaftar';

        $pendaftaran = Pendaftaran::create($data);

        $antrianCount = Antrian::where('tanggal', $data['tanggal_daftar'])->count() + 1;

        Antrian::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nomor_antrian' => str_pad((string) $antrianCount, 3, '0', STR_PAD_LEFT),
            'tanggal' => $data['tanggal_daftar'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('pendaftaran.data')->with('success', 'Pendaftaran berhasil dan antrean diterbitkan.');
    }

    /**
     * Mengubah data pendaftaran.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function pendaftaran_edit(Request $request, Pendaftaran $pendaftaran): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $pendaftaran->load(['pasien', 'jadwalDokter.dokter', 'antrian']);

            $pasien = Pasien::where('status', 'aktif')->get();
            $jadwal = JadwalDokter::with('dokter')->where('aktif', true)->get();

            return view('pendaftaran.edit', compact('pendaftaran', 'pasien', 'jadwal'));
        }

        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'jadwal_dokter_id' => ['required', 'exists:jadwal_dokter,id'],
            'tanggal_daftar' => ['required', 'date'],
            'keluhan' => ['required', 'string'],
        ]);

        $pendaftaran->update($data);

        if ($pendaftaran->antrian) {
            $pendaftaran->antrian->update(['tanggal' => $data['tanggal_daftar']]);
        }

        return redirect()->route('pendaftaran.data')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    /**
     * Menghapus pendaftaran beserta antrean terkait (hanya jika belum diperiksa).
     */
    public function pendaftaran_hapus(Pendaftaran $pendaftaran): RedirectResponse
    {
        if ($pendaftaran->antrian?->status === 'selesai') {
            return back()->withErrors(['id' => 'Pendaftaran dengan antrean selesai tidak dapat dihapus.']);
        }

        $pendaftaran->antrian()?->delete();
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.data')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}