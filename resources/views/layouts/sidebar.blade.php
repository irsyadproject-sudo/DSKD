<aside class="sidebar" id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <i class="bi bi-heart-pulse-fill"></i>
        <div>
            <span class="d-block">Klinik Sehat</span>
            <small class="text-white-50" style="font-size:0.7rem;">Sistem Informasi Klinik</small>
        </div>
    </div>

    <nav class="px-3 pb-3">
        @php
            $user = auth()->user();
            $route = request()->route() ? request()->route()->getName() : '';
            $isActive = function (array|string $names) use ($route): string {
                foreach ((array) $names as $n) {
                    if (str_starts_with($route, $n)) {
                        return 'active';
                    }
                }

                return '';
            };
        @endphp

        <a href="{{ route('dashboard') }}" class="nav-link d-block mb-1 {{ $route === 'dashboard' ? 'active' : '' }} mb-2">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        @if ($user->isAdmin())
            <div class="menu-label">Master Data</div>
            <a href="{{ route('pasien.data') }}" class="nav-link d-block mb-1 {{ $isActive('pasien') }}">
                <i class="bi bi-people-fill"></i> Pasien
            </a>
            <a href="{{ route('dokter.data') }}" class="nav-link d-block mb-1 {{ $isActive('dokter') }}">
                <i class="bi bi-person-badge-fill"></i> Dokter
            </a>
            <a href="{{ route('jadwal.data') }}" class="nav-link d-block mb-1 {{ $isActive('jadwal') }}">
                <i class="bi bi-calendar-week-fill"></i> Jadwal Dokter
            </a>
            <a href="{{ route('tindakan.data') }}" class="nav-link d-block mb-1 {{ $isActive('tindakan') }}">
                <i class="bi bi-clipboard2-pulse-fill"></i> Tindakan
            </a>
            <a href="{{ route('obat.data') }}" class="nav-link d-block mb-1 {{ $isActive('obat') }}">
                <i class="bi bi-capsule"></i> Obat
            </a>

            <div class="menu-label">Transaksi</div>
            <a href="{{ route('pendaftaran.data') }}" class="nav-link d-block mb-1 {{ $isActive('pendaftaran') }}">
                <i class="bi bi-journal-plus"></i> Pendaftaran
            </a>
            <a href="{{ route('antrian.data') }}" class="nav-link d-block mb-1 {{ $isActive('antrian') }}">
                <i class="bi bi-list-ol"></i> Antrean
            </a>
            <a href="{{ route('pembayaran.data') }}" class="nav-link d-block mb-1 {{ $isActive('pembayaran') }}">
                <i class="bi bi-cash-coin"></i> Pembayaran
            </a>

            <div class="menu-label">Lainnya</div>
            <a href="{{ route('laporan.cetak') }}" class="nav-link d-block mb-1 {{ $isActive('laporan') }}">
                <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
            </a>
        @endif

        @if ($user->isDokter())
            <div class="menu-label">Praktik</div>
            <a href="{{ route('pemeriksaan.data') }}" class="nav-link d-block mb-1 {{ $isActive('pemeriksaan') }}">
                <i class="bi bi-clipboard2-check-fill"></i> Pemeriksaan
            </a>
            <a href="{{ route('resep.data') }}" class="nav-link d-block mb-1 {{ $isActive('resep') }}">
                <i class="bi bi-eyedropper"></i> Resep
            </a>
            <a href="{{ route('rekam_medis.data') }}" class="nav-link d-block mb-1 {{ $isActive('rekam-medis') }}">
                <i class="bi bi-file-earmark-medical-fill"></i> Rekam Medis
            </a>
        @endif

        @if ($user->isPasien())
            <div class="menu-label">Layanan</div>
            <a href="{{ route('pasien.portal.pendaftaran') }}" class="nav-link d-block mb-1 {{ $isActive('pasien.portal.pendaftaran') }}">
                <i class="bi bi-pencil-square"></i> Pendaftaran
            </a>
            <a href="{{ route('pasien.portal.status') }}" class="nav-link d-block mb-1 {{ $isActive('pasien.portal.status') }}">
                <i class="bi bi-hourglass-split"></i> Status Antrean
            </a>
            <a href="{{ route('pasien.portal.riwayat') }}" class="nav-link d-block mb-1 {{ $isActive('pasien.portal.riwayat') }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
        @endif

        <div class="menu-label">Akun</div>
        <a href="{{ route('profile.edit') }}" class="nav-link d-block mb-1 {{ $route === 'profile.edit' ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i> Profil Saya
        </a>
    </nav>
</aside>
