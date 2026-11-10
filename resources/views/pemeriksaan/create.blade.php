@extends('layouts.app')

@section('title', 'Input Pemeriksaan')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Input Pemeriksaan</h4>
            <small class="text-muted">Nomor Antrean {{ $antrian->nomor_antrian }}</small>
        </div>
        <a href="{{ route('pemeriksaan.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pemeriksaan.add', $antrian) }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pasien</label>
                        <input type="text" value="{{ $antrian->pendaftaran?->pasien?->nama ?? '-' }}" class="form-control bg-body-secondary" readonly>
                        <input type="hidden" name="pasien_id" value="{{ $antrian->pendaftaran?->pasien_id }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" value="{{ old('tanggal_periksa', now()->toDateString()) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" rows="3">{{ old('keluhan', $antrian->pendaftaran?->keluhan) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan Fisik</label>
                        <textarea name="catatan_fisik" class="form-control" rows="3">{{ old('catatan_fisik') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tindakan (bisa pilih banyak)</label>
                        <select name="tindakan_id[]" class="form-select" multiple size="6">
                            @foreach ($tindakan as $t)
                                <option value="{{ $t->id }}">{{ $t->nama }} - Rp {{ number_format($t->tarif, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Tahan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan & Selesaikan</button>
                    <a href="{{ route('pemeriksaan.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection