@extends('layouts.app')

@section('title', 'Pendaftaran Baru')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Pendaftaran Baru</h4>
            <small class="text-muted">Daftarkan pasien dan terbitkan nomor antrean</small>
        </div>
        <a href="{{ route('pendaftaran.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pendaftaran.add') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pasien</label>
                        <select name="pasien_id" class="form-select" required>
                            <option value="">Pilih Pasien</option>
                            @foreach ($pasien as $p)
                                <option value="{{ $p->id }}">{{ $p->no_rm }} - {{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jadwal (Dokter / Hari / Jam)</label>
                        <select name="jadwal_dokter_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}">
                                    {{ $j->dokter?->nama ?? '-' }} - {{ $j->hari }} {{ $j->jam_mulai }} ({{ $j->ruang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Daftar</label>
                        <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', now()->toDateString()) }}" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
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