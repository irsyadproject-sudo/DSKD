@extends('layouts.print')

@section('title', 'Cetak Laporan')
@section('content')
    <h1 class="text-center fw-bold mb-1">LAPORAN KLINIK SEHAT</h1>
    <p class="text-center text-muted mb-4">
        Jenis: {{ strtoupper(str_replace('_', ' ', $jenis ?? 'pasien')) }} | Periode: {{ $dari ?? '-' }} s/d {{ $sampai ?? '-' }}
    </p>

    <table class="table table-sm table-bordered mb-0">
        <thead>
            <tr>
                <th class="text-start">No</th>
                <th class="text-start">Detail</th>
                <th class="text-end">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $index => $row)
                @php
                    switch ($jenis ?? 'pasien') {
                        case 'pembayaran':
                            $detail = ($row->pendaftaran?->pasien?->nama ?? '-') . ' - ' . ($row->no_kuitansi ?? '');
                            $nilai = 'Rp ' . number_format($row->total_biaya, 0, ',', '.');
                            break;
                        case 'obat':
                            $detail = ($row->kode ?? '') . ' - ' . ($row->nama ?? '') . ' (stok: ' . ($row->stok ?? 0) . ')';
                            $nilai = 'Rp ' . number_format($row->harga ?? 0, 0, ',', '.');
                            break;
                        case 'pendaftaran':
                            $detail = ($row->no_pendaftaran ?? '') . ' - ' . ($row->pasien?->nama ?? '-');
                            $nilai = ($row->tanggal_daftar?->format('d-m-Y') ?? '');
                            break;
                        case 'antrean':
                            $detail = 'No. ' . ($row->nomor_antrian ?? '-') . ' - ' . ($row->pendaftaran?->pasien?->nama ?? '-');
                            $nilai = ($row->tanggal?->format('d-m-Y') ?? '') . ' | ' . ($row->status ?? '');
                            break;
                        case 'pemeriksaan':
                            $detail = ($row->pasien?->nama ?? '-') . ' - ' . ($row->dokter?->nama ?? '-');
                            $nilai = ($row->tanggal_periksa?->format('d-m-Y') ?? '');
                            break;
                        case 'rekam_medis':
                            $detail = ($row->pasien?->nama ?? '-') . ' - ' . ($row->diagnosis ?? '-');
                            $nilai = ($row->tanggal_periksa?->format('d-m-Y') ?? '');
                            break;
                        case 'dokter':
                            $detail = ($row->nama ?? '') . ' - ' . ($row->spesialisasi ?? '');
                            $nilai = $row->status ?? '';
                            break;
                        default:
                            $detail = ($row->no_rm ?? '') . ' - ' . ($row->nama ?? '');
                            $nilai = $row->status ?? '';
                            break;
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail }}</td>
                    <td class="text-end">{{ $nilai }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="text-end text-muted mt-4 mb-0">Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
@endsection