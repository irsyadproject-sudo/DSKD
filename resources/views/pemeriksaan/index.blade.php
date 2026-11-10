@extends('layouts.app')

@section('title', 'Antrean Pemeriksaan')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Daftar Antrean Pasien yang Harus Diperiksa</h4>
            <small class="text-muted">Pilih antrean untuk mulai pemeriksaan. Gunakan filter tanggal bila perlu.</small>
        </div>
    </div>

    <form class="card shadow-sm mb-4" method="GET" action="{{ route('pemeriksaan.data') }}">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ $dari ?? '' }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ $sampai ?? '' }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary text-white">Filter</button>
                    <a href="{{ route('pemeriksaan.data') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor Antrean</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Keluhan</th>
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
                            <td>{{ $a->pendaftaran?->pasien?->nama ?? '-' }}</td>
                            <td>{{ $a->tanggal?->format('d-m-Y') }}</td>
                            <td>{{ $a->pendaftaran?->keluhan ?? '-' }}</td>
                            <td><span class="badge text-bg-{{ $st }} badge-status">{{ $stLabel }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('pemeriksaan.add', $a) }}" class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-clipboard2-pulse me-1"></i> Periksa
                                </a>
                                @if ($a->status === 'selesai' && $a->pemeriksaan->count())
                                    <a href="{{ route('pemeriksaan.edit', $a->pemeriksaan->first()) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Tidak ada antrean untuk diperiksa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection