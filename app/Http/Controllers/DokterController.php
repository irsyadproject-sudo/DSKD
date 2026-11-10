<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DokterController extends Controller
{
    /**
     * Menampilkan data dokter.
     */
    public function dokter_data(): View
    {
        $dokter = Dokter::latest()->get();

        return view('dokter.index', compact('dokter'));
    }

    /**
     * Menambah data dokter baru.
     * GET -> tampilkan form, POST -> simpan.
     */
    public function dokter_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('dokter.create');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_sip' => ['nullable', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'tarif_konsultasi' => ['nullable', 'numeric', 'min:0'],
        ]);

        $role = Role::where('name', 'dokter')->value('id');
        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'] ?: ('dokter.' . Str::slug($data['nama']) . '.' . Str::random(4) . '@klinik.test'),
            'password' => Hash::make('password'),
            'role_id' => $role,
        ]);

        $data['user_id'] = $user->id;
        $data['status'] = 'aktif';

        Dokter::create($data);

        return redirect()->route('dokter.data')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /**
     * Mengubah data dokter.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function dokter_edit(Request $request, Dokter $dokter): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('dokter.edit', compact('dokter'));
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_sip' => ['nullable', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'tarif_konsultasi' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $dokter->update($data);

        if ($dokter->user) {
            $dokter->user->update(['name' => $data['nama'], 'email' => $data['email'] ?: $dokter->user->email]);
        }

        return redirect()->route('dokter.data')->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Menghapus data dokter.
     */
    public function dokter_hapus(Dokter $dokter): RedirectResponse
    {
        $dokter->delete();

        return redirect()->route('dokter.data')->with('success', 'Data dokter berhasil dihapus.');
    }

    /**
     * Mencetak data dokter.
     */
    public function dokter_cetak(Dokter $dokter): View
    {
        return view('dokter.cetak', compact('dokter'));
    }
}