@extends('layouts.app')

@section('title', 'Pendaftaran Online')
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="page-title mb-0">Pendaftaran Mandiri Pasien</h4>
            <small class="text-muted">Daftar sebelum berkunjung ke klinik</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pasien.portal.pendaftaran') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Dokter / Poli</label>
                        <select name="jadwal_dokter_id" id="jadwalDokterSelect" class="form-select" required>
                            <option value="">Pilih Jadwal Dokter</option>
                            @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}"
                                    data-hari="{{ $j->hari }}"
                                    data-jam-mulai="{{ $j->jam_mulai }}"
                                    data-jam-selesai="{{ $j->jam_selesai }}"
                                    data-ruang="{{ $j->ruang }}"
                                    {{ old('jadwal_dokter_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->dokter?->nama ?? '-' }} - {{ $j->hari }} {{ $j->jam_mulai }} ({{ $j->ruang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Daftar</label>
                        <select name="tanggal_daftar" id="tanggalDaftarSelect"
                                class="form-select" data-old="{{ old('tanggal_daftar') }}" required>
                            <option value="">Pilih jadwal dokter terlebih dahulu</option>
                        </select>
                        <small class="text-muted" id="infoPraktek"></small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-brand text-white"><i class="bi bi-send me-1"></i> Daftar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var jadwalSelect = document.getElementById('jadwalDokterSelect');
            var tanggalSelect = document.getElementById('tanggalDaftarSelect');
            var infoPraktek = document.getElementById('infoPraktek');
            if (!jadwalSelect || !tanggalSelect) return;

            var namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var JUMLAH_TANGGAL = 14;
            var RENTANG = 60;

            function pad(n) { return (n < 10 ? '0' : '') + n; }

            function fmtTanggal(d) {
                return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
            }

            function perbaruiTanggal() {
                var oldValue = tanggalSelect.getAttribute('data-old') || '';
                tanggalSelect.innerHTML = '';

                var option = jadwalSelect.options[jadwalSelect.selectedIndex];
                var target = option && option.value ? option.getAttribute('data-hari') : null;

                if (!target) {
                    tanggalSelect.appendChild(new Option('Pilih jadwal dokter terlebih dahulu', ''));
                    tanggalSelect.disabled = true;
                    if (infoPraktek) infoPraktek.textContent = '';
                    return;
                }

                if (infoPraktek) {
                    var jamMulai = option.getAttribute('data-jam-mulai') || '';
                    var jamSelesai = option.getAttribute('data-jam-selesai') || '';
                    var ruang = option.getAttribute('data-ruang') || '';
                    infoPraktek.textContent = 'Hari ' + target + ' pukul ' + jamMulai +
                        (jamSelesai ? ' - ' + jamSelesai : '') + (ruang ? ' di ' + ruang : '');
                }

                var mulai = new Date();
                mulai.setHours(0, 0, 0, 0);
                mulai.setDate(mulai.getDate() + 1);

                var ditemukan = 0;
                for (var i = 0; i < RENTANG && ditemukan < JUMLAH_TANGGAL; i++) {
                    var calon = new Date(mulai);
                    calon.setDate(calon.getDate() + i);
                    if (namaHari[calon.getDay()] === target) {
                        tanggalSelect.appendChild(new Option(
                            calon.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }),
                            fmtTanggal(calon)
                        ));
                        ditemukan++;
                    }
                }

                if (ditemukan === 0) {
                    tanggalSelect.appendChild(new Option('Tidak ada tanggal tersedia', ''));
                    tanggalSelect.disabled = true;
                    return;
                }

                tanggalSelect.disabled = false;
                if (oldValue) {
                    tanggalSelect.value = oldValue;
                }
            }

            jadwalSelect.addEventListener('change', perbaruiTanggal);
            perbaruiTanggal();
        });
    </script>
@endpush