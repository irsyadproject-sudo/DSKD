@extends('layouts.app')

@section('title', 'Riwayat Pasien')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Riwayat Rekam Medis & Biaya</h4>
            <small class="text-muted">Riwayat pemeriksaan Anda</small>
        </div>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Dokter</th>
                        <th>Diagnosis</th>
                        <th>Tindakan</th>
                        <th class="text-end">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemeriksaan as $p)
                        @php
                            $totalTindakan = $p->pemeriksaanTindakan->sum('subtotal');
                            $totalObat = $p->resep->sum(fn ($r) => $r->detailResep->sum('subtotal'));
                        @endphp
                        <tr>
                            <td>{{ $p->tanggal_periksa?->format('d-m-Y') }}</td>
                            <td>{{ $p->dokter?->nama ?? '-' }}</td>
                            <td>{{ $p->diagnosis ?? '-' }}</td>
                            <td>
                                @foreach ($p->pemeriksaanTindakan as $pt)
                                    <div>{{ $pt->tindakan?->nama ?? '-' }}</div>
                                @endforeach
                            </td>
                            <td class="text-end fw-bold">Rp {{ number_format($totalTindakan + $totalObat, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Belum ada riwayat pemeriksaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection