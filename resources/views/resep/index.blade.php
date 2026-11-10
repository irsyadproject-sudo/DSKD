@extends('layouts.app')

@section('title', 'Daftar Resep')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Daftar Resep</h4>
            <small class="text-muted">Resep yang telah diterbitkan oleh Anda</small>
        </div>
        <a href="{{ route('resep.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Input Resep
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No. Resep</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Obat</th>
                        <th>Aturan Pakai</th>
                        <th>Total</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resep as $r)
                        <tr>
                            <td>{{ $r->no_resep }}</td>
                            <td>{{ $r->pemeriksaan?->pasien?->nama ?? '-' }}</td>
                            <td>{{ $r->tanggal?->format('d-m-Y') }}</td>
                            <td>
                                @foreach ($r->detailResep as $dr)
                                    <div>{{ $dr->obat?->nama ?? '-' }} ({{ $dr->qty }} {{ $dr->obat?->satuan ?? '' }})</div>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($r->detailResep as $dr)
                                    <div>{{ $dr->aturan_pakai ?? '-' }}</div>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($r->detailResep->sum('subtotal'), 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('resep.edit', $r) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('resep.hapus', $r) }}" class="d-inline" onsubmit="return confirm('Hapus resep ini? Stok obat akan dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                <a href="{{ route('resep.cetak', $r) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-printer me-1"></i> Cetak
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Belum ada resep.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection