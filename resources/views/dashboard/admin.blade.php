@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .welcome-card {
            background-color: #0d6efd !important;
            background-image: linear-gradient(120deg, #0a58ca 0%, #0d6efd 55%, #3b82f6 100%) !important;
            background-size: 220% 220%;
            animation: gradientShift 12s ease infinite;
            position: relative;
            overflow: hidden;
            color: #fff !important;
        }
        [data-bs-theme="dark"] .welcome-card {
            background-color: #0a58ca !important;
            background-image: linear-gradient(120deg, #0b3f8f 0%, #0a58ca 55%, #1e6fd9 100%) !important;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .welcome-card .blob {
            position: absolute; border-radius: 50%;
            background: rgba(255, 255, 255, 0.09);
            filter: blur(2px);
            animation: floaty 8s ease-in-out infinite;
            pointer-events: none;
        }
        .welcome-card .blob.b1 { width: 300px; height: 300px; top: -140px; right: -60px; }
        .welcome-card .blob.b2 { width: 150px; height: 150px; bottom: -70px; left: 30%; animation-delay: -3s; background: rgba(255,255,255,0.06); }
        .welcome-card .blob.b3 { width: 90px; height: 90px; top: 20px; left: -40px; animation-delay: -5s; background: rgba(255,255,255,0.07); }
        @keyframes floaty {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-22px) scale(1.07); }
        }
        .welcome-card .wave {
            position: absolute; bottom: -2px; left: 0; right: 0; height: 46px;
            background: radial-gradient(circle at 12px -6px, transparent 12px, rgba(255,255,255,0.08) 13px);
            background-size: 34px 28px; opacity: 0.5; pointer-events: none;
        }
        .welcome-card .card-body { position: relative; z-index: 1; color: #fff !important; }
        .welcome-avatar {
            width: 58px; height: 58px; border-radius: 1rem;
            background: rgba(255, 255, 255, 0.22);
            border: 2px solid rgba(255, 255, 255, 0.45);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1.3rem; color: #fff;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.18); flex-shrink: 0;
        }
        .welcome-card .quick-btn {
            background: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.9) !important;
            color: #0b1b33 !important; font-weight: 600; border-radius: 0.75rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }
        .welcome-card .quick-btn:hover {
            background: rgba(255, 255, 255, 0.85) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
        }
        .clock-pill {
            background: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.9) !important;
            color: #0b1b33 !important; font-weight: 600;
        }
        .clock-pill .tt { letter-spacing: 0.14em; font-variant-numeric: tabular-nums; }

        .stat-card {
            position: relative; border: none; border-radius: 1rem; overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card::before {
            content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--stat-color, var(--brand-primary));
            transition: width 0.22s ease;
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(var(--shadow-color), 0.14);
        }
        .stat-card:hover::before { width: 9px; }
        .stat-card .stat-icon {
            width: 54px; height: 54px; border-radius: 0.9rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.45rem; transition: transform 0.25s ease;
        }
        .stat-card:hover .stat-icon { transform: scale(1.12) rotate(-6deg); }
        .stat-card .stat-watermark {
            position: absolute; right: -10px; bottom: -16px; font-size: 5rem; opacity: 0.06;
        }
        .stat-card .stat-trend {
            display: inline-flex; align-items: center; gap: 0.25rem;
            font-size: 0.72rem; font-weight: 600;
        }
        .counter {
            transition: color 0.2s ease;
        }
        .revenue-card {
            position: relative; overflow: hidden; border: none; border-radius: 1.2rem;
            background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
            color: #fff;
        }
        [data-bs-theme="dark"] .revenue-card {
            background: linear-gradient(135deg, #043323 0%, #065f46 55%, #047857 100%);
        }
        .revenue-card .blob {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.08); pointer-events: none;
        }
        .revenue-card .blob.r1 { width: 220px; height: 220px; top: -70px; right: -50px; }
        .revenue-card .blob.r2 { width: 120px; height: 120px; bottom: -40px; left: 20%; background: rgba(255,255,255,0.05); }
        .revenue-card .card-body { position: relative; z-index: 1; }

        .card-table { border: none; border-radius: 1rem; }
        .badge-status { font-size: 0.72rem; padding: 0.4em 0.7em; }
        .fade-slide { opacity: 0; transform: translateY(16px); transition: opacity 0.55s ease, transform 0.55s ease; }
        .fade-slide.in-view { opacity: 1; transform: translateY(0); }
        .item-row { transition: background 0.15s ease; }
        .item-row:hover { background: rgba(13, 110, 253, 0.05); }
        [data-bs-theme="dark"] .item-row:hover { background: rgba(255, 255, 255, 0.04); }
        .empty-bounce { animation: emptyFloat 2.6s ease-in-out infinite; display: inline-block; }
        @keyframes emptyFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
@endpush

@section('content')
    @php
        \Carbon\Carbon::setLocale('id');
        $namaUser = auth()->user()->name ?? 'Admin';
        $inisial = collect(explode(' ', trim($namaUser)))->filter()->take(2)
            ->map(fn ($w) => strtoupper(mb_substr($w, 0, 1)))->implode('');
        $jam = (int) now()->format('G');
        $sapaan = ($jam >= 4 && $jam < 11) ? 'Selamat Pagi'
            : (($jam >= 11 && $jam < 15) ? 'Selamat Siang'
            : (($jam >= 15 && $jam < 18) ? 'Selamat Sore' : 'Selamat Malam'));
        $hp = $pendaftaran_hari_ini;
        $totalDaftar = ($hp ?? 0) + ($antrian_menunggu ?? 0);
    @endphp

    {{-- Kartu sambutan --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 welcome-card">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>
        <div class="wave"></div>
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="welcome-avatar">{{ $inisial ?: 'A' }}</div>
                        <div>
                            <span class="d-block small fw-semibold text-uppercase" style="color:rgba(255,255,255,0.8); letter-spacing:0.08em;">{{ $sapaan }}</span>
                            <h4 class="text-white fw-bold mb-0">Halo, {{ $namaUser }}</h4>
                            <span class="small" style="color:rgba(255,255,255,0.8);">Administrator &middot; Klinik Sehat</span>
                        </div>
                    </div>
                    <p class="mb-3" style="color:rgba(255,255,255,0.82); max-width:560px;">
                        Pantau aktivitas klinik hari ini—pendaftaran, antrean, dan transaksi—selengkapnya di dashboard Anda.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('pendaftaran.add') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-journal-plus me-1"></i> Pendaftaran
                        </a>
                        <a href="{{ route('pasien.add') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-person-plus me-1"></i> Tambah Pasien
                        </a>
                        <a href="{{ route('antrian.data') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-list-ol me-1"></i> Kelola Antrean
                        </a>
                        <a href="{{ route('laporan.cetak') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-file-earmark-bar-graph me-1"></i> Laporan
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge clock-pill rounded-pill px-3 py-2 mb-2">
                        <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <br>
                    <span class="badge clock-pill rounded-pill px-3 py-2">
                        <i class="bi bi-clock me-1"></i><span class="tt" id="liveClock">--:--:--</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu statistik --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['total-pasien', 'Total Pasien', $total_pasien, 'bi-people-fill', '#0d6efd', 'Pasien terdaftar di sistem'],
                ['total-dokter', 'Total Dokter', $total_dokter, 'bi-person-badge-fill', '#198754', 'Dokter aktif & praktik'],
                ['pendaftaran-hari-ini', 'Pendaftaran Hari Ini', $pendaftaran_hari_ini, 'bi-journal-plus', '#ffc107', 'Pasien mendaftar hari ini'],
                ['antrean-menunggu', 'Antrean Menunggu', $antrian_menunggu, 'bi-hourglass-split', '#8b5cf6', 'Antrean berstatus menunggu'],
            ];
        @endphp
        @foreach ($stats as [$id, $label, $value, $icon, $c, $desc])
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100" style="--stat-color:{{ $c }};" title="{{ $desc }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="bi {{ $icon }} stat-watermark"></i>
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background:{{ $c }}1f;color:{{ $c }};"><i class="bi {{ $icon }}"></i></div>
                        <div>
                            <div class="fs-3 fw-bold counter" id="counter-{{ $id }}" data-target="{{ $value }}" style="color:var(--heading-color);">0</div>
                            <div class="text-muted small">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Total transaksi (revenue) --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-4">
            <div class="card revenue-card shadow-sm h-100">
                <div class="blob r1"></div>
                <div class="blob r2"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon" style="width:48px;height:48px;border-radius:0.9rem;background:rgba(255,255,255,0.18);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div>
                            <div class="small fw-semibold text-uppercase" style="color:rgba(255,255,255,0.75); letter-spacing:0.06em;">Total Transaksi Lunas</div>
                            <div class="small" style="color:rgba(255,255,255,0.65);">Akumulasi seluruh pembayaran</div>
                        </div>
                    </div>
                    <div class="display-5 fw-bold">Rp {{ number_format($total_transaksi, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row g-3 h-100">
                <div class="col-sm-6">
                    <div class="card card-table shadow-sm h-100 fade-slide">
                        <div class="card-body">
                            <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing:0.06em;"><i class="bi bi-journal-plus me-1 text-primary"></i>Pendaftaran Hari Ini</div>
                            <div class="d-flex align-items-end justify-content-between mt-2">
                                <div class="display-6 fw-bold" style="color:var(--heading-color);">{{ $pendaftaran_hari_ini }}</div>
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-three-dots"></i> terdaftar</span>
                            </div>
                            <div class="progress mt-3" style="height:6px;background:var(--surface-subtle);">
                                <div class="progress-bar" style="width:100%;background:var(--brand-primary);"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card card-table shadow-sm h-100 fade-slide">
                        <div class="card-body">
                            <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing:0.06em;"><i class="bi bi-hourglass-split me-1 text-info"></i>Antrean Menunggu</div>
                            <div class="d-flex align-items-end justify-content-between mt-2">
                                <div class="display-6 fw-bold" style="color:var(--heading-color);">{{ $antrian_menunggu }}</div>
                                <span class="badge bg-info-subtle text-info"><i class="bi bi-hourglass-split"></i> proses</span>
                            </div>
                            <div class="progress mt-3" style="height:6px;background:var(--surface-subtle);">
                                <div class="progress-bar" style="width:100%;background:#0dcaf0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel pendaftaran & antrean --}}
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card card-table shadow-sm fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-journal-plus me-2 text-primary"></i>Pendaftaran Terbaru</h6>
                    <a href="{{ route('pendaftaran.data') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>No. Pendaftaran</th><th>Pasien</th><th>Tanggal</th></tr></thead>
                        <tbody>
                            @forelse ($pendaftaran_terbaru as $p)
                                <tr class="item-row">
                                    <td>
                                        <span class="fw-semibold" style="color:var(--brand-primary);">#{{ $p->no_pendaftaran }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center fw-semibold" style="width:30px;height:30px;font-size:0.72rem;">
                                                {{ strtoupper(mb_substr(collect(explode(' ', trim($p->pasien?->nama ?? '?')))->first() ?? '?', 0, 1)) }}
                                            </span>
                                            {{ $p->pasien?->nama ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ $p->tanggal_daftar?->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4"><i class="bi bi-inbox empty-bounce d-block fs-3 mb-1"></i>Belum ada pendaftaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-table shadow-sm fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-list-ol me-2 text-info"></i>Antrean Hari Ini</h6>
                    <a href="{{ route('antrian.data') }}" class="btn btn-sm btn-outline-info">Kelola Antrean</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>No.</th><th>Pasien</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse ($antrian_hari_ini as $a)
                                @php
                                    $map = ['menunggu'=>['Menunggu','secondary'],'dipanggil'=>['Dipanggil','warning'],'diperiksa'=>['Diperiksa','primary'],'selesai'=>['Selesai','success'],'batal'=>['Batal','danger']];
                                    [$st,$stColor] = $map[$a->status] ?? [$a->status,'secondary'];
                                @endphp
                                <tr class="item-row">
                                    <td>
                                        <span class="badge rounded-pill text-bg-primary" style="font-size:0.8rem;min-width:44px;">{{ $a->nomor_antrian }}</span>
                                    </td>
                                    <td>{{ $a->pendaftaran?->pasien?->nama ?? '-' }}</td>
                                    <td><span class="badge text-bg-{{ $stColor }} badge-status">
                                        @if ($a->status === 'menunggu') <i class="bi bi-hourglass-split me-1"></i>
                                        @elseif ($a->status === 'dipanggil') <i class="bi bi-bell-fill me-1"></i>
                                        @elseif ($a->status === 'diperiksa') <i class="bi bi-activity me-1"></i>
                                        @elseif ($a->status === 'selesai') <i class="bi bi-check-lg me-1"></i>
                                        @elseif ($a->status === 'batal') <i class="bi bi-x-lg me-1"></i>
                                        @endif
                                        {{ $st }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4"><i class="bi bi-inbox empty-bounce d-block fs-3 mb-1"></i>Tidak ada antrean hari ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (el) { new bootstrap.Tooltip(el); });

            function tickClock() {
                var el = document.getElementById('liveClock');
                if (el) el.textContent = new Date().toLocaleTimeString('id-ID');
            }
            tickClock();
            setInterval(tickClock, 1000);

            document.querySelectorAll('.counter').forEach(function (counter) {
                var target = parseInt(counter.getAttribute('data-target') || '0', 10);
                var duration = 800;
                var startTime = null;
                function update(ts) {
                    if (!startTime) startTime = ts;
                    var progress = Math.min((ts - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    counter.textContent = Math.floor(eased * target);
                    if (progress < 1) requestAnimationFrame(update);
                    else counter.textContent = target;
                }
                requestAnimationFrame(update);
            });

            var fadeEls = document.querySelectorAll('.fade-slide');
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) { entry.target.classList.add('in-view'); observer.unobserve(entry.target); }
                    });
                }, { threshold: 0.1 });
                fadeEls.forEach(function (el) { observer.observe(el); });
            } else {
                fadeEls.forEach(function (el) { el.classList.add('in-view'); });
            }
        });
    </script>
@endpush