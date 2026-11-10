@extends('layouts.app')

@section('title', 'Data Pendaftaran')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Data Pendaftaran</h4>
            <small class="text-muted">Kelola pendaftaran dan antrean pasien</small>
        </div>
        <a href="{{ route('pendaftaran.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Pendaftaran Baru
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Dokter/Jadwal</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftaran as $p)
                        @php
                            $map = [
                                'terdaftar' => ['primary', 'Terdaftar'],
                                'proses' => ['warning', 'Proses'],
                                'selesai' => ['success', 'Selesai'],
                                'batal' => ['danger', 'Batal'],
                            ];
                            [$st, $stLabel] = $map[$p->status] ?? ['secondary', $p->status];
                        @endphp
                        <tr>
                            <td>{{ $p->no_pendaftaran }}</td>
                            <td>{{ $p->pasien?->nama ?? '-' }}</td>
                            <td>{{ $p->tanggal_daftar?->format('d-m-Y') }}</td>
                            <td>
                                {{ $p->jadwalDokter?->dokter?->nama ?? '-' }}<br>
                                <small class="text-muted">{{ $p->jadwalDokter?->hari ?? '' }} {{ $p->jadwalDokter?->jam_mulai ?? '' }}</small>
                            </td>
                            <td>{{ $p->keluhan }}</td>
                            <td><span class="badge text-bg-{{ $st }} badge-status">{{ $stLabel }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('pendaftaran.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('pendaftaran.hapus', $p) }}" class="d-inline" onsubmit="return confirm('Hapus pendaftaran ini beserta antreannya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Belum ada pendaftaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pendaftaran->hasPages())
            <div class="card-footer py-2 px-3">
                {{ $pendaftaran->links() }}
            </div>
        @endif
    </div>
@endsection