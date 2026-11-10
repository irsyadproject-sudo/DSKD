@extends('layouts.app')

@section('title', 'Jadwal Dokter')

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Jadwal Praktik Dokter</h4>
            <small class="text-muted">Atur jadwal praktik dokter klinik</small>
        </div>
        <a href="{{ route('jadwal.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Dokter</th><th>Hari</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Ruang</th><th>Kuota</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($jadwal as $j)
                        <tr>
                            <td class="fw-semibold">{{ $j->dokter?->nama ?? '-' }}</td>
                            <td><span class="badge text-bg-light border">{{ $j->hari }}</span></td>
                            <td>{{ $j->jam_mulai }}</td>
                            <td>{{ $j->jam_selesai }}</td>
                            <td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $j->ruang }}</td>
                            <td>{{ $j->kuota }}</td>
                            <td>
                                @if ($j->aktif)
                                    <span class="badge text-bg-success badge-status">Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary badge-status">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('jadwal.edit', $j) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('jadwal.hapus', $j) }}" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">Belum ada jadwal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
