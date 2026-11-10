@extends('layouts.app')

@section('title', 'Edit Tindakan')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Edit Data / Tarif Tindakan</h4>
            <small class="text-muted">Perbarui master tindakan medis</small>
        </div>
        <a href="{{ route('tindakan.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('tindakan.edit', $tindakan) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode</label>
                        <input type="text" name="kode" value="{{ old('kode', $tindakan->kode ?? '') }}" class="form-control bg-body-secondary" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $tindakan->nama ?? '') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $tindakan->deskripsi ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tarif</label>
                        <input type="number" name="tarif" value="{{ old('tarif', $tindakan->tarif ?? '') }}" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" {{ old('status', $tindakan->status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $tindakan->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                    <a href="{{ route('tindakan.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection