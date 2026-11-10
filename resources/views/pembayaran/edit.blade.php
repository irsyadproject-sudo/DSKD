@extends('layouts.app')

@section('title', 'Edit Pembayaran')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Edit Pembayaran</h4>
            <small class="text-muted">No. {{ $pembayaran->no_kuitansi }}</small>
        </div>
        <a href="{{ route('pembayaran.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Ringkasan</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted">Pasien</td>
                            <td class="fw-semibold text-end">{{ $pembayaran->pendaftaran?->pasien?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Pendaftaran</td>
                            <td class="fw-semibold text-end">{{ $pembayaran->pendaftaran?->no_pendaftaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Bayar</td>
                            <td class="fw-semibold text-end">{{ $pembayaran->tanggal_bayar?->toDateString() }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tindakan</td>
                            <td class="text-end">Rp {{ number_format($pembayaran->total_tindakan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Obat</td>
                            <td class="text-end">Rp {{ number_format($pembayaran->total_obat, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-active">
                            <td class="fw-bold">Total Bayar</td>
                            <td class="fw-bold text-end">Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('pembayaran.edit', $pembayaran) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                                    @foreach (['tunai' => 'Tunai', 'transfer' => 'Transfer Bank', 'e-wallet' => 'E-Wallet', 'kartu_debit' => 'Kartu Debit', 'kartu_kredit' => 'Kartu Kredit'] as $kode => $label)
                                        <option value="{{ $kode }}" @selected($pembayaran->metode_pembayaran === $kode)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="lunas" @selected($pembayaran->status === 'lunas')>Lunas</option>
                                    <option value="batal" @selected($pembayaran->status === 'batal')>Batal</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                            <a href="{{ route('pembayaran.data') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection