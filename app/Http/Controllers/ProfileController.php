<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * ProfileController
 * Halaman profil agar user dapat memperbarui akun (data akun, password)
 * beserta data profil sesuai perannya (Pasien/Dokter).
 */
class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna yang sedang login.
     */
    public function edit(): View
    {
        $user = auth()->user();

        return view('profile.edit', [
            'user' => $user,
            'pasien' => $user->pasien,
            'dokter' => $user->dokter,
        ]);
    }

    /**
     * Perbarui data akun (nama, email, avatar).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $oldAvatar = $user->avatar;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('avatars', 'public');

            if (! $path) {
                return back()
                    ->withErrors(['avatar' => 'Foto profil gagal disimpan. Silakan coba lagi.'])
                    ->withInput();
            }

            $data['avatar'] = $path;
        }

        $user->update($data);

        // Hapus foto lama hanya setelah data baru berhasil disimpan.
        if (isset($data['avatar']) && $oldAvatar && $oldAvatar !== $data['avatar']) {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Sinkronkan nama pada profil peran (apabila tersedia).
        if ($user->pasien) {
            $user->pasien->update(['nama' => $data['name']]);
        }
        if ($user->dokter) {
            $user->dokter->update(['nama' => $data['name']]);
        }

        return back()->with('success', 'Data akun berhasil diperbarui.');
    }

    /**
     * Ubah password pengguna (perlu password lama).
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    /**
     * Perbarui data profil sesuai peran (Pasien/Dokter).
     */
    public function updateData(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isPasien() && $user->pasien) {
            $data = $request->validate([
                'no_hp' => ['nullable', 'string', 'max:20'],
                'alamat' => ['nullable', 'string', 'max:500'],
                'golongan_darah' => ['nullable', 'in:A,B,AB,O'],
            ]);

            $user->pasien->update($data);

            return back()->with('success', 'Data profil pasien berhasil diperbarui.');
        }

        if ($user->isDokter() && $user->dokter) {
            $data = $request->validate([
                'no_hp' => ['nullable', 'string', 'max:20'],
            ]);

            $user->dokter->update($data);

            return back()->with('success', 'Data profil dokter berhasil diperbarui.');
        }

        return back()->with('success', 'Data profil berhasil diperbarui.');
    }
}