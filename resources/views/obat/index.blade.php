@extends('layouts.app')

@section('title', 'Master Obat')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Master Obat</h4>
            <small class="text-muted">Kelola data obat dan stok</small>
        </div>
        <a href="{{ route('obat.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Tambah Obat
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Stok Min</th>
                        <th>Harga</th>
                        <th>Kedaluwarsa</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obat as $o)
                        <tr>
                            <td>{{ $o->kode }}</td>
                            <td>{{ $o->nama }}</td>
                            <td>{{ $o->satuan }}</td>
                            <td>
                                <span class="{{ $o->stok <= $o->stok_minimum ? 'fw-bold text-danger' : '' }}">{{ $o->stok }}</span>
                            </td>
                            <td>{{ $o->stok_minimum }}</td>
                            <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                            <td>{{ $o->tanggal_kedaluwarsa?->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                <span class="badge text-bg-{{ $o->status === 'aktif' ? 'success' : 'danger' }} badge-status">{{ ucfirst($o->status) }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('obat.edit', $o) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('obat.hapus', $o) }}" onsubmit="return confirm('Yakin hapus obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">Belum ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection