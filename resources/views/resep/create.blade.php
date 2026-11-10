@extends('layouts.app')

@section('title', 'Input Resep')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Input Resep Obat</h4>
            <small class="text-muted">Buat resep untuk pasien yang telah diperiksa</small>
        </div>
        <a href="{{ route('resep.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('resep.add') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pemeriksaan</label>
                        <select name="pemeriksaan_id" class="form-select @error('pemeriksaan_id') is-invalid @enderror" required>
                            <option value="">Pilih Pemeriksaan</option>
                            @foreach ($pemeriksaanList as $p)
                                <option value="{{ $p->id }}" @selected((string) old('pemeriksaan_id') === (string) $p->id)>
                                    {{ $p->tanggal_periksa?->format('d-m-Y') }} - {{ $p->pasien?->nama ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('pemeriksaan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Obat</label>
                        <select name="obat_id" class="form-select" required>
                            <option value="">Pilih Obat</option>
                            @foreach ($obat as $o)
                                <option value="{{ $o->id }}">
                                    {{ $o->nama }} (stok: {{ $o->stok }}) - Rp {{ number_format($o->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah (Qty)</label>
                        <input type="number" name="qty" value="{{ old('qty', 1) }}" class="form-control" min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aturan Pakai</label>
                        <input type="text" name="aturan_pakai" value="{{ old('aturan_pakai') }}" placeholder="cth: 3x sehari 1 tablet" class="form-control">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan Resep</button>
                    <a href="{{ route('resep.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection