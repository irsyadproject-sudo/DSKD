@extends('layouts.print')

@section('title', 'Cetak Resep')
@section('content')
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-0">KLINIK SEHAT</h1>
        <small class="text-muted">Jl. Contoh No. 1, Bandung</small>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <p class="mb-1">No. Resep: <strong>{{ $resep->no_resep }}</strong></p>
            <p class="mb-1">Tanggal: {{ $resep->tanggal?->format('d-m-Y') }}</p>
            <p class="mb-1">Pasien: {{ $resep->pemeriksaan?->pasien?->nama ?? '-' }}</p>
        </div>
        <div class="col-6 text-end">
            <p class="mb-1">Dokter: {{ $resep->pemeriksaan?->dokter?->nama ?? '-' }}</p>
            <p class="mb-1">Diagnosis: {{ $resep->pemeriksaan?->diagnosis ?? '-' }}</p>
        </div>
    </div>

    <table class="table table-bordered text-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Aturan Pakai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resep->detailResep as $index => $dr)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dr->obat?->nama ?? '-' }}</td>
                    <td>{{ $dr->qty }} {{ $dr->obat?->satuan ?? '' }}</td>
                    <td>{{ $dr->aturan_pakai ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada obat pada resep ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="text-end text-muted small mt-5">Dokter Penanggung Jawab</p>
    <p class="text-end fw-semibold mt-4">{{ $resep->pemeriksaan?->dokter?->nama ?? '......................' }}</p>
    <p class="text-end text-muted small">Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
@endsection