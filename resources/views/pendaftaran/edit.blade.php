@extends('layouts.app')

@section('title', 'Edit Pendaftaran')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Edit Pendaftaran</h4>
            <small class="text-muted">No. {{ $pendaftaran->no_pendaftaran }}</small>
        </div>
        <a href="{{ route('pendaftaran.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pendaftaran.edit', $pendaftaran) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pasien</label>
                        <select name="pasien_id" class="form-select @error('pasien_id') is-invalid @enderror" required>
                            @foreach ($pasien as $p)
                                <option value="{{ $p->id }}" @selected($pendaftaran->pasien_id === $p->id)>
                                    {{ $p->no_rm }} - {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jadwal (Dokter / Hari / Jam)</label>
                        <select name="jadwal_dokter_id" class="form-select @error('jadwal_dokter_id') is-invalid @enderror" required>
                            @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}" @selected($pendaftaran->jadwal_dokter_id === $j->id)>
                                    {{ $j->dokter?->nama ?? '-' }} - {{ $j->hari }} {{ $j->jam_mulai }} ({{ $j->ruang }})
                                </option>
                            @endforeach
                        </select>
                        @error('jadwal_dokter_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Daftar</label>
                        <input type="date" name="tanggal_daftar"
                            value="{{ old('tanggal_daftar', $pendaftaran->tanggal_daftar?->toDateString()) }}"
                            class="form-control @error('tanggal_daftar') is-invalid @enderror" required>
                        @error('tanggal_daftar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3" required>{{ old('keluhan', $pendaftaran->keluhan) }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                    <a href="{{ route('pendaftaran.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection