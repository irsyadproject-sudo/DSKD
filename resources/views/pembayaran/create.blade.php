@extends('layouts.app')

@section('title', 'Input Pembayaran')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Input Pembayaran</h4>
            <small class="text-muted">Menerima pembayaran pasien</small>
        </div>
        <a href="{{ route('pembayaran.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pembayaran.add') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendaftaran (belum dibayar)</label>
                        <select name="pendaftaran_id" class="form-select" required>
                            <option value="">Pilih Pendaftaran</option>
                            @foreach ($pendaftaran as $p)
                                <option value="{{ $p->id }}">{{ $p->no_pendaftaran }} - {{ $p->pasien?->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select">
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer</option>
                            <option value="e-wallet">E-Wallet</option>
                            <option value="kartu_debit">Kartu Debit</option>
                            <option value="kartu_kredit">Kartu Kredit</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Biaya</label>
                        <input type="text" value="Dihitung otomatis dari tindakan & obat" class="form-control bg-body-secondary" disabled>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan & Lunasi</button>
                    <a href="{{ route('pembayaran.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection