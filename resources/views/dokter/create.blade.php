@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
    <h4 class="page-title mb-1">Tambah Dokter</h4>
    <small class="text-muted d-block mb-4">Lengkapi data dokter baru</small>

    <div class="card shadow-sm" style="max-width:820px; border:none; border-radius:1rem;">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('dokter.add') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. SIP</label>
                        <input type="text" name="no_sip" value="{{ old('no_sip') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Spesialisasi</label>
                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tarif Konsultasi</label>
                        <input type="number" name="tarif_konsultasi" value="{{ old('tarif_konsultasi') }}" class="form-control" step="0.01">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-brand text-white px-4">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                    <a href="{{ route('dokter.data') }}" class="btn btn-outline-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
