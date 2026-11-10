@extends('layouts.print')

@section('title', 'Cetak Data Dokter')
@section('content')
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-0">KLINIK SEHAT</h1>
        <small class="text-muted">Data Dokter</small>
    </div>

    <div class="mb-4">
        <h5 class="fw-bold">Identitas Dokter</h5>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width:30%;">Nama Lengkap</th>
                    <td>{{ $dokter->nama }}</td>
                </tr>
                <tr>
                    <th>No. SIP</th>
                    <td>{{ $dokter->no_sip ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Spesialisasi</th>
                    <td>{{ $dokter->spesialisasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $dokter->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $dokter->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tarif Konsultasi</th>
                    <td>Rp {{ number_format($dokter->tarif_konsultasi ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($dokter->status) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text-muted small">Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
@endsection