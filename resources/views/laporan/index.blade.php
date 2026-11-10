@extends('layouts.app')

@section('title', 'Laporan Sistem')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Filter Laporan</h4>
            <small class="text-muted">Pilih jenis laporan dan periode</small>
        </div>
    </div>

    <form class="card shadow-sm mb-4" method="GET" action="{{ route('laporan.cetak') }}">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label mb-1">Jenis Laporan</label>
                    <select name="jenis" class="form-select">
                        <option value="pasien" {{ ($jenis ?? 'pasien') === 'pasien' ? 'selected' : '' }}>Laporan Pasien</option>
                        <option value="dokter" {{ ($jenis ?? '') === 'dokter' ? 'selected' : '' }}>Laporan Dokter</option>
                        <option value="pendaftaran" {{ ($jenis ?? '') === 'pendaftaran' ? 'selected' : '' }}>Laporan Pendaftaran</option>
                        <option value="antrean" {{ ($jenis ?? '') === 'antrean' ? 'selected' : '' }}>Laporan Antrean</option>
                        <option value="pemeriksaan" {{ ($jenis ?? '') === 'pemeriksaan' ? 'selected' : '' }}>Laporan Pemeriksaan</option>
                        <option value="rekam_medis" {{ ($jenis ?? '') === 'rekam_medis' ? 'selected' : '' }}>Laporan Rekam Medis</option>
                        <option value="obat" {{ ($jenis ?? '') === 'obat' ? 'selected' : '' }}>Laporan Obat</option>
                        <option value="pembayaran" {{ ($jenis ?? '') === 'pembayaran' ? 'selected' : '' }}>Laporan Pembayaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ $dari ?? '' }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ $sampai ?? '' }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" name="cetak" value="0" class="btn btn-primary text-white"><i class="bi bi-eye me-1"></i> Tampilkan</button>
                    <button type="submit" name="cetak" value="1" formaction="{{ route('laporan.cetak') }}" class="btn btn-success text-white"><i class="bi bi-printer me-1"></i> Cetak</button>
                </div>
            </div>
        </div>
    </form>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        @if (($jenis ?? 'pasien') === 'pasien')
                            <th>No RM</th><th>Nama</th><th>NIK</th><th>JK</th><th>No HP</th><th>Status</th>
                        @elseif (($jenis ?? '') === 'dokter')
                            <th>Nama</th><th>Spesialisasi</th><th>No HP</th><th>Status</th>
                        @elseif (($jenis ?? '') === 'pendaftaran')
                            <th>No</th><th>Pasien</th><th>Tanggal</th><th>Dokter</th><th>Status</th>
                        @elseif (($jenis ?? '') === 'antrean')
                            <th>No. Antrean</th><th>Pasien</th><th>Tanggal</th><th>Dokter</th><th>Status</th>
                        @elseif (($jenis ?? '') === 'rekam_medis')
                            <th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Diagnosis</th><th>Tindakan</th>
                        @elseif (($jenis ?? '') === 'obat')
                            <th>Kode</th><th>Nama</th><th>Stok</th><th>Harga</th><th>Status</th>
                        @elseif (($jenis ?? '') === 'pembayaran')
                            <th>Kuitansi</th><th>Pasien</th><th>Tanggal</th><th>Total</th><th>Status</th>
                        @else
                            <th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Diagnosis</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr>
                            @if (($jenis ?? 'pasien') === 'pasien')
                                <td>{{ $row->no_rm }}</td><td>{{ $row->nama }}</td><td>{{ $row->nik }}</td><td>{{ $row->jenis_kelamin }}</td><td>{{ $row->no_hp }}</td><td>
                                    <span class="badge text-bg-{{ $row->status === 'aktif' ? 'success' : 'danger' }} badge-status">{{ $row->status }}</span>
                                </td>
                            @elseif (($jenis ?? '') === 'dokter')
                                <td>{{ $row->nama }}</td><td>{{ $row->spesialisasi }}</td><td>{{ $row->no_hp }}</td><td>
                                    <span class="badge text-bg-{{ $row->status === 'aktif' ? 'success' : 'danger' }} badge-status">{{ $row->status }}</span>
                                </td>
                            @elseif (($jenis ?? '') === 'pendaftaran')
                                <td>{{ $row->no_pendaftaran }}</td><td>{{ $row->pasien?->nama ?? '-' }}</td><td>{{ $row->tanggal_daftar?->format('d-m-Y') }}</td><td>{{ $row->jadwalDokter?->dokter?->nama ?? '-' }}</td><td>{{ $row->status }}</td>
                            @elseif (($jenis ?? '') === 'antrean')
                                <td class="fw-bold">{{ $row->nomor_antrian }}</td><td>{{ $row->pendaftaran?->pasien?->nama ?? '-' }}</td><td>{{ $row->tanggal?->format('d-m-Y') }}</td><td>{{ $row->pendaftaran?->jadwalDokter?->dokter?->nama ?? '-' }}</td><td>{{ $row->status }}</td>
                            @elseif (($jenis ?? '') === 'rekam_medis')
                                <td>{{ $row->tanggal_periksa?->format('d-m-Y') }}</td><td>{{ $row->pasien?->nama ?? '-' }}</td><td>{{ $row->dokter?->nama ?? '-' }}</td><td>{{ $row->diagnosis ?? '-' }}</td><td>{{ $row->pemeriksaanTindakan->count() }} tindakan</td>
                            @elseif (($jenis ?? '') === 'obat')
                                <td>{{ $row->kode }}</td><td>{{ $row->nama }}</td><td>
                                    @if ($row->stok <= $row->stok_minimum)
                                        <span class="fw-semibold text-danger">{{ $row->stok }} (menipis)</span>
                                    @else
                                        {{ $row->stok }}
                                    @endif
                                </td><td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td><td>{{ $row->status }}</td>
                            @elseif (($jenis ?? '') === 'pembayaran')
                                <td>{{ $row->no_kuitansi }}</td><td>{{ $row->pendaftaran?->pasien?->nama ?? '-' }}</td><td>{{ $row->tanggal_bayar?->format('d-m-Y') }}</td><td>Rp {{ number_format($row->total_biaya, 0, ',', '.') }}</td><td>
                                    <span class="badge text-bg-{{ $row->status === 'lunas' ? 'success' : 'danger' }} badge-status">{{ $row->status }}</span>
                                </td>
                            @else
                                <td>{{ $row->tanggal_periksa?->format('d-m-Y') }}</td><td>{{ $row->pasien?->nama ?? '-' }}</td><td>{{ $row->dokter?->nama ?? '-' }}</td><td>{{ $row->diagnosis ?? '-' }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Belum ada data untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection