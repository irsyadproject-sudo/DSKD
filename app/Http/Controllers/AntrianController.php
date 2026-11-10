<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar antrean hari ini.
     */
    public function antrian_data(): View
    {
        $antrian = Antrian::with(['pendaftaran.pasien', 'pendaftaran.jadwalDokter.dokter'])
            ->where('tanggal', now()->toDateString())
            ->orderBy('nomor_antrian')
            ->get();

        return view('antrian.index', compact('antrian'));
    }

    /**
     * Menambah/mengisi antrean.
     * GET -> tampilkan form, POST -> simpan antrean baru.
     */
    public function antrian_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $pendaftaran = Pendaftaran::with(['pasien', 'jadwalDokter.dokter'])
                ->where('status', '!=', 'batal')
                ->doesntHave('antrian')
                ->latest()
                ->get();

            return view('antrian.add', compact('pendaftaran'));
        }

        $data = $request->validate([
            'pendaftaran_id' => ['required', 'exists:pendaftaran,id'],
            'tanggal' => ['required', 'date'],
        ]);

        if (Pendaftaran::find($data['pendaftaran_id'])?->antrian) {
            return back()->withErrors(['pendaftaran_id' => 'Pendaftaran ini sudah memiliki antrean.']);
        }

        $data['nomor_antrian'] = str_pad((string) (Antrian::where('tanggal', $data['tanggal'])->count() + 1), 3, '0', STR_PAD_LEFT);
        $data['status'] = 'menunggu';

        Antrian::create($data);

        return redirect()->route('antrian.data')->with('success', 'Antrean berhasil ditambahkan.');
    }

    /**
     * Mengubah status antrean (Menunggu, Dipanggil, Diperiksa, Selesai, Batal).
     */
    public function antrian_edit(Request $request, Antrian $antrian): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:menunggu,dipanggil,diperiksa,selesai,batal'],
        ]);

        $antrian->update($data);

        $pesan = match ($data['status']) {
            'dipanggil' => 'Pasien dipanggil.',
            'diperiksa' => 'Pasien sedang diperiksa.',
            'selesai' => 'Antrean selesai.',
            'batal' => 'Antrean dibatalkan.',
            default => 'Antrean kembali menunggu.',
        };

        return redirect()->route('antrian.data')->with('success', $pesan);
    }

    /**
     * Menghapus data antrean.
     */
    public function antrian_hapus(Antrian $antrian): RedirectResponse
    {
        $antrian->delete();

        return redirect()->route('antrian.data')->with('success', 'Antrean berhasil dihapus.');
    }
}