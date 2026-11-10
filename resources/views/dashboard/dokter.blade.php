@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@push('styles')
    <style>
        .welcome-card {
            background-color: #0d9488 !important;
            background-image: linear-gradient(120deg, #065f46 0%, #0d9488 55%, #14b8a6 100%) !important;
            background-size: 220% 220%;
            animation: gradientShift 12s ease infinite;
            position: relative; overflow: hidden; color: #fff !important;
        }
        [data-bs-theme="dark"] .welcome-card {
            background-color: #065f46 !important;
            background-image: linear-gradient(120deg, #043323 0%, #065f46 55%, #0d9488 100%) !important;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .welcome-card .blob {
            position: absolute; border-radius: 50%;
            background: rgba(255, 255, 255, 0.09); filter: blur(2px);
            animation: floaty 8s ease-in-out infinite; pointer-events: none;
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
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 14px 28px rgba(var(--shadow-color), 0.14); }
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
        .jadwal-item {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 1rem 1.15rem; border-radius: 0.9rem;
            background: var(--surface-subtle); margin-bottom: 0.75rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .jadwal-item:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(var(--shadow-color), 0.1); }
        .jadwal-item .time {
            width: 72px; text-align: center; flex-shrink: 0;
            border-radius: 0.7rem; padding: 0.45rem 0.25rem;
            background: rgba(13, 110, 253, 0.1); color: var(--brand-primary);
            font-weight: 700; font-size: 0.78rem; line-height: 1.35;
        }
    </style>
@endpush

@section('content')
    @php
        \Carbon\Carbon::setLocale('id');
        $dokter = auth()->user()->dokter;
        $namaUser = $dokter?->nama ?? auth()->user()->name ?? 'Dokter';
        $spesialisasi = $dokter?->spesialisasi ?? 'Dokter';
        $inisial = collect(explode(' ', trim($namaUser)))->filter()->take(2)
            ->map(fn ($w) => strtoupper(mb_substr($w, 0, 1)))->implode('');
        $jam = (int) now()->format('G');
        $sapaan = ($jam >= 4 && $jam < 11) ? 'Selamat Pagi'
            : (($jam >= 11 && $jam < 15) ? 'Selamat Siang'
            : (($jam >= 15 && $jam < 18) ? 'Selamat Sore' : 'Selamat Malam'));

        $jumlahAntrian = $antrian_periksa->count();
        $antrianMenunggu = $antrian_periksa->where('status', 'menunggu')->count();
        $antrianDiproses = $antrian_periksa->whereIn('status', ['dipanggil', 'diperiksa'])->count();
        $jumlahJadwal = $jadwal_hari_ini->count();
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
                        <div class="welcome-avatar">{{ $inisial ?: 'D' }}</div>
                        <div>
                            <span class="d-block small fw-semibold text-uppercase" style="color:rgba(255,255,255,0.8); letter-spacing:0.08em;">{{ $sapaan }}</span>
                            <h4 class="text-white fw-bold mb-0">dr. {{ $namaUser }}</h4>
                            <span class="small" style="color:rgba(255,255,255,0.8);"><i class="bi bi-patch-check-fill me-1"></i>{{ $spesialisasi }}</span>
                        </div>
                    </div>
                    <p class="mb-3" style="color:rgba(255,255,255,0.82); max-width:560px;">
                        Pantau jadwal praktik & antrean pasien Anda hari ini. Pastikan setiap pasien ditangani dengan baik.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('pemeriksaan.data') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-clipboard2-check me-1"></i> Pemeriksaan
                        </a>
                        <a href="{{ route('resep.add') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-eyedropper me-1"></i> Buat Resep
                        </a>
                        <a href="{{ route('rekam_medis.data') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-file-earmark-medical me-1"></i> Rekam Medis
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
                ['jumlah-jadwal', 'Jadwal Hari Ini', $jumlahJadwal, 'bi-calendar-week', '#0d6efd'],
                ['jumlah-antrian', 'Antrean Aktif', $jumlahAntrian, 'bi-list-ol', '#8b5cf6'],
                ['menunggu', 'Menunggu', $antrianMenunggu, 'bi-hourglass-split', '#ffc107'],
                ['diproses', 'Sedang Diproses', $antrianDiproses, 'bi-activity', '#0dcaf0'],
            ];
        @endphp
        @foreach ($stats as [$id, $label, $value, $icon, $c])
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100" style="--stat-color:{{ $c }};">
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

    <div class="row g-3">
        {{-- Jadwal praktik --}}
        <div class="col-lg-5">
            <div class="card card-table shadow-sm h-100 fade-slide">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-calendar-week me-2 text-primary"></i>Jadwal Praktik Hari Ini</h6>
                </div>
                <div class="card-body">
                    @forelse ($jadwal_hari_ini as $j)
                        <div class="jadwal-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="time">
                                    <span class="d-block">{{ $j->jam_mulai }}</span>
                                    <span class="d-block text-muted" style="font-size:0.68rem;">s/d</span>
                                    <span class="d-block">{{ $j->jam_selesai }}</span>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $j->hari }}</div>
                                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $j->ruang }}</div>
                                </div>
                            </div>
                            <span class="badge text-bg-primary"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x empty-bounce d-block fs-1 mb-2"></i>Tidak ada jadwal hari ini.<br>
                            <small>Silakan hubungi admin untuk pengaturan jadwal.</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Antrean periksa --}}
        <div class="col-lg-7">
            <div class="card card-table shadow-sm h-100 fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-list-ol me-2 text-info"></i>Antrean Periksa</h6>
                    <a href="{{ route('pemeriksaan.data') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>No.</th><th>Pasien</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($antrian_periksa as $a)
                                @php
                                    $map = ['menunggu'=>['Menunggu','secondary'],'dipanggil'=>['Dipanggil','warning'],'diperiksa'=>['Diperiksa','primary'],'selesai'=>['Selesai','success'],'batal'=>['Batal','danger']];
                                    [$st,$stColor] = $map[$a->status] ?? [$a->status,'secondary'];
                                    $next = in_array($a->status, ['menunggu','dipanggil']);
                                @endphp
                                <tr class="item-row">
                                    <td>
                                        <span class="badge rounded-pill text-bg-info" style="font-size:0.8rem;min-width:44px;">{{ $a->nomor_antrian }}</span>
                                    </td>
                                    <td>{{ $a->pendaftaran?->pasien?->nama ?? '-' }}</td>
                                    <td><span class="badge text-bg-{{ $stColor }} badge-status">{{ $st }}</span></td>
                                    <td class="text-end">
                                        @if ($next)
                                            <a href="{{ route('pemeriksaan.add', $a) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-clipboard2-check me-1"></i>Periksa
                                            </a>
                                        @else
                                            <a href="{{ route('pemeriksaan.add', $a) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil me-1"></i>Lanjut
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox empty-bounce d-block fs-3 mb-1"></i>Belum ada antrean periksa.</td></tr>
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