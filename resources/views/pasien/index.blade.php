@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Data Pasien</h4>
            <small class="text-muted">Kelola data pasien klinik</small>
        </div>
        <a href="{{ route('pasien.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pasien
        </a>
    </div>

    <form class="mb-3" method="GET" action="{{ route('pasien.data') }}">
        <div class="input-group" style="max-width:420px;">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama, NIK, atau No. RM"
                   class="form-control">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
            @if ($q ?? null)
                <a href="{{ route('pasien.data') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></a>
            @endif
        </div>
    </form>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr><th>No. RM</th><th>Nama</th><th>NIK</th><th>Jenis Kelamin</th><th>No. HP</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($pasien as $p)
                        <tr>
                            <td class="fw-semibold">{{ $p->no_rm }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $p->no_hp ?? '-' }}</td>
                            <td>
                                @if ($p->status === 'aktif')
                                    <span class="badge text-bg-success badge-status">Aktif</span>
                                @else
                                    <span class="badge text-bg-danger badge-status">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pasien.edit', $p) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('pasien.cetak', $p) }}" target="_blank" class="btn btn-outline-success" title="Cetak"><i class="bi bi-printer"></i></a>
                                    <form method="POST" action="{{ route('pasien.hapus', $p) }}" onsubmit="return confirm('Yakin hapus pasien ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data pasien.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $pasien->links('pagination::bootstrap-5') }}
    </div>
@endsection
