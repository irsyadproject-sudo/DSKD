@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Data Dokter</h4>
            <small class="text-muted">Kelola data dokter klinik</small>
        </div>
        <a href="{{ route('dokter.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Dokter
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Nama</th><th>No. SIP</th><th>Spesialisasi</th><th>No. HP</th><th>Tarif</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($dokter as $d)
                        <tr>
                            <td class="fw-semibold">{{ $d->nama }}</td>
                            <td>{{ $d->no_sip ?? '-' }}</td>
                            <td><span class="badge text-bg-info-subtle text-info-emphasis">{{ $d->spesialisasi }}</span></td>
                            <td>{{ $d->no_hp ?? '-' }}</td>
                            <td>Rp {{ number_format($d->tarif_konsultasi, 0, ',', '.') }}</td>
                            <td>
                                @if ($d->status === 'aktif')
                                    <span class="badge text-bg-success badge-status">Aktif</span>
                                @else
                                    <span class="badge text-bg-danger badge-status">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('dokter.edit', $d) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('dokter.cetak', $d) }}" target="_blank" class="btn btn-outline-success" title="Cetak"><i class="bi bi-printer"></i></a>
                                    <form method="POST" action="{{ route('dokter.hapus', $d) }}" onsubmit="return confirm('Yakin hapus dokter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data dokter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
