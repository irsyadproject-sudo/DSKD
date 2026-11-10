@extends('layouts.print')

@section('title', 'Struk Pembayaran')
@section('content')
    <div class="mx-auto" style="max-width: 420px;">
        <h1 class="text-center fw-bold mb-0">KLINIK SEHAT</h1>
        <p class="text-center text-muted mb-4">Jl. Contoh No. 1, Bandung</p>

        <div class="mb-3">
            <div>No. Kuitansi: <strong>{{ $pembayaran->no_kuitansi }}</strong></div>
            <div>Tanggal: {{ $pembayaran->tanggal_bayar?->format('d-m-Y') }}</div>
            <div>Pasien: {{ $pembayaran->pendaftaran?->pasien?->nama ?? '-' }}</div>
            <div>Pendaftaran: {{ $pembayaran->pendaftaran?->no_pendaftaran ?? '-' }}</div>
        </div>

        <table class="table table-sm table-bordered mb-0">
            <thead>
                <tr>
                    <th class="text-start">Item</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayaran->detailPembayaran as $d)
                    <tr>
                        <td>{{ $d->nama_item }}</td>
                        <td class="text-end">{{ $d->qty }}</td>
                        <td class="text-end">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada rincian.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="fw-semibold">Total Biaya</td>
                    <td class="text-end fw-bold">Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <p class="text-center text-muted mt-4 mb-0">Terima kasih atas kunjungan Anda.</p>
    </div>
@endsection