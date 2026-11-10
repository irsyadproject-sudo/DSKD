<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TindakanController extends Controller
{
    /**
     * Menampilkan jenis dan tarif tindakan.
     */
    public function tindakan_data(): View
    {
        $tindakan = Tindakan::latest()->get();

        return view('tindakan.index', compact('tindakan'));
    }

    /**
     * Menambah jenis tindakan baru (form tambah ada di halaman data).
     */
    public function tindakan_add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:tindakan,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tarif' => ['required', 'numeric', 'min:0'],
        ]);

        $data['status'] = 'aktif';

        Tindakan::create($data);

        return redirect()->route('tindakan.data')->with('success', 'Tindakan berhasil ditambahkan.');
    }

    /**
     * Mengubah data/tarif tindakan.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function tindakan_edit(Request $request, Tindakan $tindakan): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('tindakan.edit', compact('tindakan'));
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tarif' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $tindakan->update($data);

        return redirect()->route('tindakan.data')->with('success', 'Tindakan berhasil diperbarui.');
    }

    /**
     * Menghapus data tindakan.
     */
    public function tindakan_hapus(Tindakan $tindakan): RedirectResponse
    {
        $tindakan->delete();

        return redirect()->route('tindakan.data')->with('success', 'Tindakan berhasil dihapus.');
    }
}