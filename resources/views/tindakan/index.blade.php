@extends('layouts.app')

@section('title', 'Jenis Tindakan')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Jenis Tindakan & Tarif</h4>
            <small class="text-muted">Kelola master tindakan medis dan tarifnya</small>
        </div>
        <button type="button" onclick="document.getElementById('formTambah').classList.remove('d-none')" class="btn btn-brand text-white">
            <i class="bi bi-plus-circle me-1"></i> Tambah Tindakan
        </button>
    </div>

    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Tambah Tindakan Baru</h6>
            <form method="POST" action="{{ route('tindakan.add') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kode</label>
                        <input type="text" name="kode" value="{{ old('kode') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tarif</label>
                        <input type="number" name="tarif" value="{{ old('tarif') }}" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-control">
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white">Simpan</button>
                    <button type="button" onclick="document.getElementById('formTambah').classList.add('d-none')" class="btn btn-outline-secondary">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Tarif</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tindakan as $t)
                        <tr>
                            <td>{{ $t->kode }}</td>
                            <td>{{ $t->nama }}</td>
                            <td>{{ $t->deskripsi ?? '-' }}</td>
                            <td>Rp {{ number_format($t->tarif, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge text-bg-{{ $t->status === 'aktif' ? 'success' : 'danger' }} badge-status">{{ ucfirst($t->status) }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tindakan.edit', $t) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('tindakan.hapus', $t) }}" onsubmit="return confirm('Yakin hapus tindakan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Belum ada data tindakan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection