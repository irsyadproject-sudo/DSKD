@extends('layouts.print')

@section('title', 'Cetak Data Pasien')
@section('content')
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-0">KLINIK SEHAT</h1>
        <small class="text-muted">Kartu &amp; Data Pasien</small>
    </div>

    <div class="mb-4">
        <h5 class="fw-bold">Data Pasien</h5>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width:30%;">No. Rekam Medis</th>
                    <td>{{ $pasien->no_rm }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $pasien->nama }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $pasien->nik }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $pasien->tanggal_lahir?->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Golongan Darah</th>
                    <td>{{ $pasien->golongan_darah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $pasien->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pasien->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($pasien->status) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text-muted small">Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
@endsection