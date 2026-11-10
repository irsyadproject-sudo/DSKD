@extends('layouts.app')

@section('title', 'Status Antrean')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Informasi Nomor Antrean Aktif</h4>
            <small class="text-muted">Status antrean Anda hari ini</small>
        </div>
    </div>

    <div class="card shadow-sm mx-auto text-center" style="max-width: 420px;">
        <div class="card-body py-5">
            @if ($antrian)
                <p class="text-muted mb-2">Nomor Antrean Anda</p>
                <p class="display-1 fw-bold text-primary mb-4">{{ $antrian->nomor_antrian }}</p>
                <p class="text-muted mb-2">Tanggal: {{ $antrian->tanggal?->format('d-m-Y') }}</p>
                @php
                    $map = [
                        'menunggu' => ['secondary', 'Menunggu'],
                        'dipanggil' => ['warning', 'Dipanggil'],
                        'diperiksa' => ['primary', 'Diperiksa'],
                        'selesai' => ['success', 'Selesai'],
                        'batal' => ['danger', 'Batal'],
                    ];
                    [$st, $stLabel] = $map[$antrian->status] ?? ['secondary', $antrian->status];
                @endphp
                <span class="badge text-bg-{{ $st }} badge-status">{{ $stLabel }}</span>
            @else
                <p class="text-muted mb-2">Nomor Antrean Anda</p>
                <p class="display-1 fw-bold text-secondary mb-4">-</p>
                <p class="text-muted">Belum ada antrean aktif hari ini.</p>
            @endif
        </div>
    </div>
@endsection