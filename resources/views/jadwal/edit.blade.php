@extends('layouts.app')

@section('title', 'Edit Jadwal Dokter')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Edit Jadwal Dokter</h4>
            <small class="text-muted">Perbarui jadwal praktik dokter</small>
        </div>
        <a href="{{ route('jadwal.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('jadwal.edit', $jadwal) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Dokter</label>
                        <select name="dokter_id" class="form-select" required>
                            <option value="">Pilih Dokter</option>
                            @foreach ($dokter as $d)
                                <option value="{{ $d->id }}" {{ old('dokter_id', $jadwal->dokter_id) == $d->id ? 'selected' : '' }}>
                                    {{ $d->nama }} ({{ $d->spesialisasi ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-select" required>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                                <option value="{{ $h }}" {{ old('hari', $jadwal->hari) === $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ruang</label>
                        <input type="text" name="ruang" value="{{ old('ruang', $jadwal->ruang) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kuota</label>
                        <input type="number" name="kuota" value="{{ old('kuota', $jadwal->kuota) }}" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="aktif" class="form-select">
                            <option value="1" {{ old('aktif', $jadwal->aktif) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif', $jadwal->aktif) === 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white">Simpan</button>
                    <a href="{{ route('jadwal.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection