@extends('layouts.app')

@section('title', 'Tambah Antrean')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Tambah Antrean</h4>
            <small class="text-muted">Isi antrean untuk pendaftaran yang belum memiliki nomor antrean</small>
        </div>
        <a href="{{ route('antrian.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($pendaftaran->isEmpty())
                <div class="alert alert-info mb-0">
                    Tidak ada pendaftaran yang belum memiliki antrean. Antrean dibuat otomatis saat pendaftaran baru
                    diproses.
                </div>
            @else
                <form method="POST" action="{{ route('antrian.add') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pendaftaran (Pasien / Dokter)</label>
                            <select name="pendaftaran_id" class="form-select" required>
                                <option value="">Pilih Pendaftaran</option>
                                @foreach ($pendaftaran as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->pasien?->nama ?? '-' }} - {{ $p->jadwalDokter?->dokter?->nama ?? '-' }} ({{ $p->no_pendaftaran }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Antrean</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                        <a href="{{ route('antrian.data') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection