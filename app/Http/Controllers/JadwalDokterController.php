<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalDokterController extends Controller
{
    /**
     * Menampilkan jadwal praktik dokter.
     */
    public function jadwal_data(): View
    {
        $jadwal = JadwalDokter::with('dokter')->latest()->get();

        return view('jadwal.index', compact('jadwal'));
    }

    /**
     * Menambah jadwal dokter.
     * GET -> tampilkan form, POST -> simpan.
     */
    public function jadwal_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $dokter = Dokter::where('status', 'aktif')->get();

            return view('jadwal.create', compact('dokter'));
        }

        $data = $this->validasi($request);

        if ($this->jadwalBertabrakan($data['dokter_id'], $data['hari'], $data['jam_mulai'], $data['jam_selesai'])) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal bertabrakan dengan jadwal dokter yang sudah ada pada hari yang sama.'])
                ->withInput();
        }

        $data['aktif'] = true;

        JadwalDokter::create($data);

        return redirect()->route('jadwal.data')->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    /**
     * Mengubah jadwal dokter.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function jadwal_edit(Request $request, JadwalDokter $jadwal): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $dokter = Dokter::where('status', 'aktif')->get();

            return view('jadwal.edit', compact('jadwal', 'dokter'));
        }

        $data = $this->validasi($request, $jadwal->id);

        if ($this->jadwalBertabrakan($data['dokter_id'], $data['hari'], $data['jam_mulai'], $data['jam_selesai'], $jadwal->id)) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal bertabrakan dengan jadwal dokter yang sudah ada pada hari yang sama.'])
                ->withInput();
        }

        $jadwal->update($data);

        return redirect()->route('jadwal.data')->with('success', 'Jadwal dokter berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal dokter.
     */
    public function jadwal_hapus(JadwalDokter $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('jadwal.data')->with('success', 'Jadwal dokter berhasil dihapus.');
    }

    /**
     * Validasi input jadwal dokter.
     */
    private function validasi(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'dokter_id' => ['required', 'exists:dokter,id'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'jam_mulai' => ['required', 'date_format:H:i', 'before:jam_selesai'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'ruang' => ['required', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:0'],
        ]);

        if ($id) {
            $data['aktif'] = $request->validate([
                'aktif' => ['required', 'in:0,1'],
            ])['aktif'];
        }

        return $data;
    }

    /**
     * Cek apakah jadwal bertabrakan dengan jadwal lain milik dokter yang sama.
     */
    private function jadwalBertabrakan(int $dokterId, string $hari, string $mulai, string $selesai, ?int $ignoreId = null): bool
    {
        return JadwalDokter::where('dokter_id', $dokterId)
            ->where('hari', $hari)
            ->where('id', '!=', $ignoreId ?? 0)
            ->where('jam_mulai', '<', $selesai)
            ->where('jam_selesai', '>', $mulai)
            ->exists();
    }
}