<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\PemeriksaanTindakan;
use App\Models\Tindakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemeriksaanController extends Controller
{
    /**
     * Menampilkan data pemeriksaan (antrean pasien yang harus diperiksa oleh dokter yang login).
     */
    public function pemeriksaan_data(Request $request): View
    {
        $dokter = auth()->user()->dokter;

        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $antrian = Antrian::with(['pendaftaran.pasien'])
            ->whereHas('pendaftaran', function ($q) use ($dokter) {
                $q->whereHas('jadwalDokter', fn ($j) => $j->where('dokter_id', $dokter->id));
            })
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->when($dari, fn ($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('tanggal', '<=', $sampai))
            ->orderBy('tanggal')
            ->orderBy('nomor_antrian')
            ->get();

        return view('pemeriksaan.index', compact('antrian', 'dari', 'sampai'));
    }

    /**
     * Menambah/menginput hasil pemeriksaan untuk antrean tertentu.
     * GET -> tampilkan form, POST -> simpan.
     */
    public function pemeriksaan_add(Request $request, Antrian $antrian): View|RedirectResponse
    {
        $this->pastikanAntrianMilikDokter($antrian);

        if ($request->isMethod('GET')) {
            $tindakan = Tindakan::where('status', 'aktif')->get();

            return view('pemeriksaan.create', compact('antrian', 'tindakan'));
        }

        $data = $request->validate([
            'pasien_id' => ['required', 'exists:pasien,id'],
            'tanggal_periksa' => ['required', 'date'],
            'keluhan' => ['nullable', 'string'],
            'catatan_fisik' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'tindakan_id' => ['nullable', 'array'],
            'tindakan_id.*' => ['exists:tindakan,id'],
        ]);

        $dokter = auth()->user()->dokter;

        $pemeriksaan = Pemeriksaan::create([
            'antrian_id' => $antrian->id,
            'pendaftaran_id' => $antrian->pendaftaran_id,
            'dokter_id' => $dokter->id,
            'pasien_id' => $data['pasien_id'],
            'tanggal_periksa' => $data['tanggal_periksa'],
            'catatan_fisik' => $data['catatan_fisik'] ?? null,
            'keluhan' => $data['keluhan'] ?? null,
            'diagnosis' => $data['diagnosis'] ?? null,
        ]);

        foreach (($data['tindakan_id'] ?? []) as $tindakanId) {
            $tindakan = Tindakan::find($tindakanId);
            if ($tindakan) {
                PemeriksaanTindakan::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'tindakan_id' => $tindakan->id,
                    'qty' => 1,
                    'harga' => $tindakan->tarif,
                    'subtotal' => $tindakan->tarif,
                ]);
            }
        }

        $antrian->update(['status' => 'selesai']);

        return redirect()->route('pemeriksaan.data')->with('success', 'Pemeriksaan berhasil disimpan.');
    }

    /**
     * Mengubah data pemeriksaan.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function pemeriksaan_edit(Request $request, Pemeriksaan $pemeriksaan): View|RedirectResponse
    {
        $dokter = auth()->user()->dokter;

        if ($pemeriksaan->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke pemeriksaan ini.');
        }

        if ($request->isMethod('GET')) {
            $pemeriksaan->load(['pasien', 'pemeriksaanTindakan.tindakan', 'antrian']);
            $tindakan = Tindakan::where('status', 'aktif')->get();
            $tindakanTerpilih = $pemeriksaan->pemeriksaanTindakan->pluck('tindakan_id')->all();

            return view('pemeriksaan.edit', compact('pemeriksaan', 'tindakan', 'tindakanTerpilih'));
        }

        $data = $request->validate([
            'tanggal_periksa' => ['required', 'date'],
            'keluhan' => ['nullable', 'string'],
            'catatan_fisik' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'tindakan_id' => ['nullable', 'array'],
            'tindakan_id.*' => ['exists:tindakan,id'],
        ]);

        $pemeriksaan->update($data);

        $tindakanIds = $data['tindakan_id'] ?? [];
        $terpilih = collect($tindakanIds);
        $lama = $pemeriksaan->pemeriksaanTindakan()->pluck('tindakan_id');

        $pemeriksaan->pemeriksaanTindakan()
            ->whereNotIn('tindakan_id', $terpilih->all())
            ->delete();

        foreach ($terpilih->diff($lama) as $tindakanId) {
            $tindakan = Tindakan::find($tindakanId);
            if ($tindakan) {
                $pemeriksaan->pemeriksaanTindakan()->create([
                    'tindakan_id' => $tindakan->id,
                    'qty' => 1,
                    'harga' => $tindakan->tarif,
                    'subtotal' => $tindakan->tarif,
                ]);
            }
        }

        return redirect()->route('pemeriksaan.data')->with('success', 'Pemeriksaan berhasil diperbarui.');
    }

    /**
     * Menghapus data pemeriksaan.
     */
    public function pemeriksaan_hapus(Pemeriksaan $pemeriksaan): RedirectResponse
    {
        $pemeriksaan->delete();

        return redirect()->route('pemeriksaan.data')->with('success', 'Pemeriksaan berhasil dihapus.');
    }

    /**
     * Pastikan antrean milik dokter yang sedang login.
     */
    private function pastikanAntrianMilikDokter(Antrian $antrian): void
    {
        $dokter = auth()->user()->dokter;

        $milik = $dokter
            && Pendaftaran::where('id', $antrian->pendaftaran_id)
                ->whereHas('jadwalDokter', fn ($j) => $j->where('dokter_id', $dokter->id))
                ->exists();

        if (!$milik) {
            abort(403, 'Anda tidak memiliki akses ke antrean ini.');
        }
    }
}