<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasienController extends Controller
{
    /**
     * Menampilkan data pasien dengan pencarian (NIK/Nama/No RM).
     */
    public function pasien_data(Request $request): View
    {
        $q = $request->query('q');

        $pasien = Pasien::query()
            ->when($q, function ($query, $q) {
                $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('no_rm', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(15);

        return view('pasien.index', compact('pasien', 'q'));
    }

    /**
     * Menambah data pasien baru.
     * GET -> tampilkan form, POST/PUT -> simpan.
     */
    public function pasien_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('pasien.create');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'golongan_darah' => ['nullable', 'in:A,B,AB,O'],
        ]);

        $role = Role::where('name', 'pasien')->value('id');
        $user = User::create([
            'name' => $data['nama'],
            'email' => 'pasien.' . Str::slug($data['nama']) . '.' . Str::random(4) . '@klinik.test',
            'password' => Hash::make('password'),
            'role_id' => $role,
        ]);

        $data['user_id'] = $user->id;
        $data['no_rm'] = Pasien::buatNoRm();
        $data['status'] = 'aktif';

        Pasien::create($data);

        return redirect()->route('pasien.data')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    /**
     * Mencetak data/kartu pasien.
     */
    public function pasien_cetak(Pasien $pasien): View
    {
        return view('pasien.cetak', compact('pasien'));
    }

    /**
     * Mengubah data pasien.
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function pasien_edit(Request $request, Pasien $pasien): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            return view('pasien.edit', compact('pasien'));
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $pasien->update($data);

        if ($pasien->user) {
            $pasien->user->update(['name' => $data['nama']]);
        }

        return redirect()->route('pasien.data')->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Menghapus data pasien.
     */
    public function pasien_hapus(Pasien $pasien): RedirectResponse
    {
        $pasien->delete();

        return redirect()->route('pasien.data')->with('success', 'Data pasien berhasil dihapus.');
    }
}