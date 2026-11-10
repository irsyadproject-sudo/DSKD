<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ObatController extends Controller
{
    /**
     * Menampilkan data dan stok obat.
     */
    public function obat_data(): View
    {
        $obat = Obat::latest()->get();

        return view('obat.index', compact('obat'));
    }

    /**
     * Menambah data obat baru.
     * GET -> tampilkan form, POST -> simpan.
     */
    public function obat_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('obat.create');
        }

        $data = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:obat,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_kedaluwarsa' => ['nullable', 'date'],
        ]);

        $data['status'] = 'aktif';

        Obat::create($data);

        return redirect()->route('obat.data')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Mengubah data/stok obat.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function obat_edit(Request $request, Obat $obat): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('obat.edit', compact('obat'));
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_kedaluwarsa' => ['nullable', 'date'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $obat->update($data);

        return redirect()->route('obat.data')->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Menghapus data obat.
     */
    public function obat_hapus(Obat $obat): RedirectResponse
    {
        $obat->delete();

        return redirect()->route('obat.data')->with('success', 'Obat berhasil dihapus.');
    }
}