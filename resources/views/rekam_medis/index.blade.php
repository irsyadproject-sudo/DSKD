@extends('layouts.app')

@section('title', 'Rekam Medis')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Riwayat Pemeriksaan Pasien</h4>
            <small class="text-muted">Arsip rekam medis seluruh pasien</small>
        </div>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Diagnosis</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemeriksaan as $p)
                        <tr>
                            <td>{{ $p->tanggal_periksa?->format('d-m-Y') }}</td>
                            <td>{{ $p->pasien?->nama ?? '-' }}</td>
                            <td>{{ $p->dokter?->nama ?? '-' }}</td>
                            <td>{{ $p->diagnosis ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('rekam_medis.detail', $p) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Belum ada riwayat pemeriksaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection