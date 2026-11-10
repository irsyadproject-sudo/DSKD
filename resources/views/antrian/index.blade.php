@extends('layouts.app')

@section('title', 'Antrean')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Pemanggilan Antrean</h4>
            <small class="text-muted">Kelola status antrean pasien</small>
        </div>
        <a href="{{ route('antrian.add') }}" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Tambah Antrean
        </a>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor Antrean</th>
                        <th>No. Pendaftaran</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($antrian as $a)
                        @php
                            $map = [
                                'menunggu' => ['secondary', 'Menunggu'],
                                'dipanggil' => ['warning', 'Dipanggil'],
                                'diperiksa' => ['primary', 'Diperiksa'],
                                'selesai' => ['success', 'Selesai'],
                                'batal' => ['danger', 'Batal'],
                            ];
                            [$st, $stLabel] = $map[$a->status] ?? ['secondary', $a->status];
                        @endphp
                        <tr>
                            <td class="fw-bold">{{ $a->nomor_antrian }}</td>
                            <td>{{ $a->pendaftaran?->no_pendaftaran ?? '-' }}</td>
                            <td>{{ $a->pendaftaran?->pasien?->nama ?? '-' }}</td>
                            <td>{{ $a->tanggal?->format('d-m-Y') }}</td>
                            <td><span class="badge text-bg-{{ $st }} badge-status">{{ $stLabel }}</span></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <form method="POST" action="{{ route('antrian.edit', $a) }}" class="d-inline-flex gap-1 justify-content-end">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm w-auto">
                                            @foreach (['menunggu', 'dipanggil', 'diperiksa', 'selesai', 'batal'] as $s)
                                                <option value="{{ $s }}" {{ $a->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                    <form method="POST" action="{{ route('antrian.hapus', $a) }}" onsubmit="return confirm('Yakin hapus antrean ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Belum ada antrean hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection