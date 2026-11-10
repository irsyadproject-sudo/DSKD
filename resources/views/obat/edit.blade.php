@extends('layouts.app')

@section('title', 'Edit Obat')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Edit Data & Stok Obat</h4>
            <small class="text-muted">Perbarui data dan stok obat</small>
        </div>
        <a href="{{ route('obat.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('obat.edit', $obat) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode</label>
                        <input type="text" name="kode" value="{{ old('kode', $obat->kode ?? '') }}" class="form-control bg-body-secondary" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $obat->nama ?? '') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $obat->satuan ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $obat->stok ?? '') }}" class="form-control" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $obat->stok_minimum ?? '') }}" class="form-control" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga', $obat->harga ?? '') }}" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kedaluwarsa</label>
                        <input type="date" name="tanggal_kedaluwarsa" value="{{ old('tanggal_kedaluwarsa', $obat->tanggal_kedaluwarsa?->format('Y-m-d') ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" {{ old('status', $obat->status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $obat->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                    <a href="{{ route('obat.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection