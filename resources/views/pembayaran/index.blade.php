@extends('layouts.app')

@section('title', 'Pembayaran')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Riwayat Transaksi Pembayaran</h4>
            <small class="text-muted">Pantau pembayaran pasien di klinik</small>
        </div>
        <a href="{{ route('pembayaran.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Input Pembayaran
        </a>
    </div>

    <form class="card shadow-sm mb-4" method="GET" action="{{ route('pembayaran.data') }}">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label mb-1">Dokter</label>
                    <select name="dokter_id" class="form-select">
                        <option value="">Semua Dokter</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->id }}" {{ (string) ($dokterId ?? '') === (string) $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ $dari ?? '' }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ $sampai ?? '' }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary text-white">Filter</button>
                    <a href="{{ route('pembayaran.data') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No. Kuitansi</th>
                        <th>No. Pendaftaran</th>
                        <th>Tanggal</th>
                        <th>Total Biaya</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran as $p)
                        <tr>
                            <td>{{ $p->no_kuitansi }}</td>
                            <td>{{ $p->pendaftaran?->no_pendaftaran ?? '-' }}</td>
                            <td>{{ $p->tanggal_bayar?->format('d-m-Y') }}</td>
                            <td class="fw-bold">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</td>
                            <td>{{ $p->metode_pembayaran }}</td>
                            <td>
                                <span class="badge text-bg-{{ $p->status === 'lunas' ? 'success' : 'danger' }} badge-status">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pembayaran.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('pembayaran.hapus', $p) }}" class="d-inline" onsubmit="return confirm('Hapus pembayaran ini? Pembayaran dapat diproses ulang.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                <a href="{{ route('pembayaran.cetak', $p) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-receipt me-1"></i> Cetak Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Belum ada transaksi pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pembayaran->hasPages())
            <div class="card-footer py-2 px-3">
                {{ $pembayaran->links() }}
            </div>
        @endif
    </div>
@endsection