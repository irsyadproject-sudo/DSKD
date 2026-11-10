@extends('layouts.app')

@section('title', 'Detail Rekam Medis')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Detail Hasil Pemeriksaan</h4>
            <small class="text-muted">Rincian rekam medis pasien</small>
        </div>
        <a href="{{ route('rekam_medis.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <small class="text-muted d-block">Pasien</small>
                    <span class="fw-semibold">{{ $pemeriksaan->pasien?->nama ?? '-' }}</span>
                    <div class="text-muted">{{ $pemeriksaan->pasien?->no_rm ?? '' }}</div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Dokter</small>
                    <span class="fw-semibold">{{ $pemeriksaan->dokter?->nama ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Tanggal Periksa</small>
                    <span class="fw-semibold">{{ $pemeriksaan->tanggal_periksa?->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Diagnosis</small>
                    <span class="fw-semibold">{{ $pemeriksaan->diagnosis ?? '-' }}</span>
                </div>
                <div class="col-12">
                    <small class="text-muted d-block">Keluhan</small>
                    <span class="fw-semibold">{{ $pemeriksaan->keluhan ?? '-' }}</span>
                </div>
                <div class="col-12">
                    <small class="text-muted d-block">Catatan Fisik</small>
                    <span class="fw-semibold">{{ $pemeriksaan->catatan_fisik ?? '-' }}</span>
                </div>
            </div>

            <hr>

            <h6 class="fw-semibold">Tindakan</h6>
            <ul class="mb-4">
                @forelse ($pemeriksaan->pemeriksaanTindakan as $pt)
                    <li>{{ $pt->tindakan?->nama ?? '-' }} - Rp {{ number_format($pt->subtotal, 0, ',', '.') }}</li>
                @empty
                    <li class="text-muted">Tidak ada tindakan.</li>
                @endforelse
            </ul>

            <h6 class="fw-semibold">Obat yang Diberikan</h6>
            <ul class="mb-0">
                @forelse ($pemeriksaan->resep as $resep)
                    @foreach ($resep->detailResep as $dr)
                        <li>
                            {{ $dr->obat?->nama ?? '-' }} ({{ $dr->qty }} {{ $dr->obat?->satuan ?? '' }}) -
                            {{ $dr->aturan_pakai ?? '-' }} - Rp {{ number_format($dr->subtotal, 0, ',', '.') }}
                        </li>
                    @endforeach
                @empty
                    <li class="text-muted">Tidak ada obat.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection