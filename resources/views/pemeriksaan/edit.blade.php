@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Edit Pemeriksaan</h4>
            <small class="text-muted">{{ $pemeriksaan->pasien?->nama ?? '-' }} &middot; {{ $pemeriksaan->tanggal_periksa?->toDateString() }}</small>
        </div>
        <a href="{{ route('pemeriksaan.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pemeriksaan.edit', $pemeriksaan) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pasien</label>
                        <input type="text" value="{{ $pemeriksaan->pasien?->nama ?? '-' }}" class="form-control bg-body-secondary" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa"
                            value="{{ old('tanggal_periksa', $pemeriksaan->tanggal_periksa?->toDateString()) }}"
                            class="form-control @error('tanggal_periksa') is-invalid @enderror" required>
                        @error('tanggal_periksa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" rows="3">{{ old('keluhan', $pemeriksaan->keluhan) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan Fisik</label>
                        <textarea name="catatan_fisik" class="form-control" rows="3">{{ old('catatan_fisik', $pemeriksaan->catatan_fisik) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $pemeriksaan->diagnosis) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tindakan (bisa pilih banyak)</label>
                        <select name="tindakan_id[]" class="form-select" multiple size="6">
                            @foreach ($tindakan as $t)
                                <option value="{{ $t->id }}" @selected(in_array($t->id, $tindakanTerpilih))>
                                    {{ $t->nama }} - Rp {{ number_format($t->tarif, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Tahan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                    <a href="{{ route('pemeriksaan.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection