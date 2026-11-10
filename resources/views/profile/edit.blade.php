@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <h4 class="page-title mb-1">Profil Saya</h4>
    <small class="text-muted d-block mb-4">Kelola data akun dan profil Anda</small>

    <div class="row g-4">
        {{-- Kolom kiri: ringkasan akun & ganti password --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4" style="border:none; border-radius:1rem;">
                <div class="card-body text-center p-4">
                    <div id="avatarPreview"
                         class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center overflow-hidden mb-3"
                         style="width:96px;height:96px; font-size:2.2rem;">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" class="w-100 h-100 object-fit-cover" alt="Avatar">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <div class="text-muted small mb-2">{{ $user->email }}</div>
                    <span class="badge bg-primary-subtle text-primary">{{ $user->roleLabel() }}</span>
                </div>
            </div>

            <div class="card shadow-sm" style="border:none; border-radius:1rem;">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-shield-lock me-2 text-primary"></i>Ganti Password</h6>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" required autocomplete="current-password">
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" minlength="8" required autocomplete="new-password">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-brand text-white w-100">
                            <i class="bi bi-check-lg me-1"></i> Simpan Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: data akun & data profil --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4" style="border:none; border-radius:1rem;">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-person-gear me-2 text-primary"></i>Data Akun</h6>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="avatar" id="avatarInput" class="form-control" accept="image/*">
                                <small class="text-muted">Maks. 2MB. Format: JPG, PNG, GIF, WebP.</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-brand text-white px-4">
                                <i class="bi bi-check-lg me-1"></i> Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($pasien || $dokter)
                <div class="card shadow-sm" style="border:none; border-radius:1rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3"><i class="bi bi-person-vcard me-2 text-primary"></i>Data Profil
                            {{ $pasien ? 'Pasien' : 'Dokter' }}</h6>
                        <form method="POST" action="{{ route('profile.data') }}">
                            @csrf
                            @method('PUT')

                            @if ($pasien)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">No. HP</label>
                                        <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" class="form-control" maxlength="20">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Golongan Darah</label>
                                        <select name="golongan_darah" class="form-select">
                                            <option value="">-</option>
                                            @foreach (['A', 'B', 'AB', 'O'] as $gd)
                                                <option value="{{ $gd }}" {{ old('golongan_darah', $pasien->golongan_darah) === $gd ? 'selected' : '' }}>
                                                    {{ $gd }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2" maxlength="500">{{ old('alamat', $pasien->alamat) }}</textarea>
                                    </div>
                                </div>
                            @endif

                            @if ($dokter)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">No. HP</label>
                                        <input type="text" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" class="form-control" maxlength="20">
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-brand text-white px-4">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('avatarInput');
            var preview = document.getElementById('avatarPreview');
            if (!input || !preview) return;

            input.addEventListener('change', function () {
                var file = input.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100" alt="Preview" style="object-fit:cover;">';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush