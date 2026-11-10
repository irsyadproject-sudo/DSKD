@extends('layouts.app')

@section('title', 'Edit Resep')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Form Edit Resep</h4>
            <small class="text-muted">{{ $resep->no_resep }} &middot; {{ $resep->pemeriksaan?->pasien?->nama ?? '-' }}</small>
        </div>
        <a href="{{ route('resep.data') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('resep.edit', $resep) }}" id="formResep">
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label mb-0">Daftar Obat</label>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnTambahRow">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Obat
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="tabelResep">
                        <thead>
                            <tr>
                                <th style="width:35%;">Obat</th>
                                <th style="width:15%;">Jumlah</th>
                                <th style="width:35%;">Aturan Pakai</th>
                                <th style="width:15%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resep->detailResep as $index => $detail)
                                <tr>
                                    <td>
                                        <select name="obat_id[]" class="form-select @error('obat_id.' . $index) is-invalid @enderror" required>
                                            @foreach ($obat as $o)
                                                <option value="{{ $o->id }}" @selected(old('obat_id.' . $index, $detail->obat_id) == $o->id)>
                                                    {{ $o->nama }} (stok {{ $o->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('obat_id.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="qty[]" class="form-control @error('qty.' . $index) is-invalid @enderror" min="1" value="{{ old('qty.' . $index, $detail->qty) }}" required>
                                        @error('qty.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" name="aturan_pakai[]" class="form-control" value="{{ old('aturan_pakai.' . $index, $detail->aturan_pakai) }}"
                                            placeholder="mis. 3x sehari 1 tablet">
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm row-hapus"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada item obat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check2 me-1"></i> Simpan</button>
                    <a href="{{ route('resep.data') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var tbody = document.querySelector('#tabelResep tbody');
            var btnTambah = document.getElementById('btnTambahRow');
            var optionsHtml = @json($obat->map(fn ($o) => '<option value="' . $o->id . '">' . e($o->nama) . ' (stok ' . $o->stok . ')</option>')->join(''));

            function kosongkan() {
                return '<td class="text-center text-muted py-4" colspan="4">Belum ada item obat.</td>';
            }

            function barisRow() {
                return '<tr>' +
                    '<td><select name="obat_id[]" class="form-select" required><option value="">Pilih Obat</option>' + optionsHtml + '</select></td>' +
                    '<td><input type="number" name="qty[]" class="form-control" min="1" value="1" required></td>' +
                    '<td><input type="text" name="aturan_pakai[]" class="form-control" placeholder="mis. 3x sehari 1 tablet"></td>' +
                    '<td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm row-hapus"><i class="bi bi-trash"></i></button></td>' +
                    '</tr>';
            }

            btnTambah.addEventListener('click', function () {
                if (tbody.children[0] && tbody.children[0].classList.contains('text-center')) {
                    tbody.innerHTML = '';
                }
                tbody.insertAdjacentHTML('beforeend', barisRow());
            });

            tbody.addEventListener('click', function (e) {
                var btn = e.target.closest('.row-hapus');
                if (!btn) return;
                var tr = btn.closest('tr');
                tr.remove();
                if (!tbody.querySelector('tr')) tbody.innerHTML = kosongkan();
            });
        })();
    </script>
@endpush