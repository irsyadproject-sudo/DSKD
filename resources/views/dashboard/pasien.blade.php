@extends('layouts.app')

@section('title', 'Dashboard Pasien')

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
        .welcome-card .card-body { color: #fff !important; }
        .welcome-card h4,
        .welcome-card .text-white { color: #fff !important; }
        .welcome-card .text-white-50 { color: rgba(255, 255, 255, 0.8) !important; }
        .welcome-card .small { color: rgba(255, 255, 255, 0.8) !important; }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .welcome-card .blob {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(2px);
            animation: floaty 8s ease-in-out infinite;
            pointer-events: none;
        }
        .welcome-card .blob.b1 { width: 300px; height: 300px; top: -140px; right: -60px; }
        .welcome-card .blob.b2 { width: 150px; height: 150px; bottom: -70px; left: 30%; animation-delay: -3s; background: rgba(255,255,255,0.05); }
        .welcome-card .blob.b3 { width: 90px; height: 90px; top: 20px; left: -40px; animation-delay: -5s; background: rgba(255,255,255,0.06); }
        @keyframes floaty {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-22px) scale(1.07); }
        }
        .welcome-card .card-body { position: relative; z-index: 1; }
        .welcome-card h4,
        .welcome-card .text-white { color: #fff !important; }
        .welcome-card .text-white-50 { color: rgba(255, 255, 255, 0.82) !important; }
        .welcome-card .wave {
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 46px;
            background: radial-gradient(circle at 12px -6px, transparent 12px, rgba(255,255,255,0.08) 13px);
            background-size: 34px 28px;
            opacity: 0.5;
            pointer-events: none;
        }
        .welcome-avatar {
            width: 58px;
            height: 58px;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.22);
            border: 2px solid rgba(255, 255, 255, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.3rem;
            color: #fff;
            letter-spacing: 0.04em;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.18);
        }
        .welcome-card .quick-btn {
            background: rgba(255, 255, 255, 0.18) !important;
            border: 1px solid rgba(255, 255, 255, 0.28) !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .welcome-card .quick-btn:hover {
            background: rgba(255, 255, 255, 0.32) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
        }
        .clock-pill {
            background: rgba(255, 255, 255, 0.18) !important;
            border: 1px solid rgba(255, 255, 255, 0.28) !important;
            color: #fff !important;
            font-weight: 600;
        }
        .clock-pill .tt {
            letter-spacing: 0.14em;
            font-variant-numeric: tabular-nums;
        }

        .stat-card {
            position: relative;
            cursor: pointer;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card::before {
            content: "";
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--stat-color, var(--brand-primary));
            transition: width 0.22s ease;
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(var(--shadow-color), 0.14);
        }
        .stat-card:hover::before { width: 9px; }
        .stat-card .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            transition: transform 0.25s ease;
        }
        .stat-card:hover .stat-icon { transform: scale(1.12) rotate(-6deg); }
        .stat-card .stat-watermark {
            position: absolute;
            right: -10px; bottom: -16px;
            font-size: 5rem;
            opacity: 0.06;
        }
        .stat-card .stat-go {
            position: absolute;
            top: 12px; right: 14px;
            font-size: 1rem;
            opacity: 0.28;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .stat-card:hover .stat-go { opacity: 0.7; transform: translateX(3px); }

        .antrian-hero {
            background: linear-gradient(150deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.02));
            border: 1px dashed rgba(13, 110, 253, 0.28);
            border-radius: 1.2rem;
        }
        .antrian-hero .hero-nomor {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.02em;
            color: var(--brand-primary);
        }
        @supports (background-clip: text) or (-webkit-background-clip: text) {
            .antrian-hero .hero-nomor {
                background: linear-gradient(120deg, var(--brand-primary), #38b2ac);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
        }
        .antrian-score {
            position: relative;
            display: inline-block;
            animation: pulse-ring 2.2s infinite;
        }
        .antrian-score .glow {
            position: absolute;
            inset: -8px;
            border-radius: 1.4rem;
            background: radial-gradient(circle, rgba(13,110,253,0.22), transparent 70%);
            z-index: -1;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.35); }
            70% { box-shadow: 0 0 0 12px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }
        .antrian-score.pop { animation: ring-pop 0.9s ease; }
        @keyframes ring-pop {
            0% { transform: scale(1); }
            40% { transform: scale(1.12); }
            100% { transform: scale(1); }
        }

        .badge-status-pulse {
            animation: badgePulse 1.6s ease infinite;
        }
        @keyframes badgePulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
            50% { box-shadow: 0 0 0 7px rgba(13, 110, 253, 0); }
        }

        .step-track {
            display: flex;
            justify-content: space-between;
            margin-top: 1.25rem;
            position: relative;
        }
        .step-track::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 12px;
            right: 12px;
            height: 3px;
            background: #e2e8f0;
            border-radius: 3px;
            z-index: 0;
        }
        .step { position: relative; z-index: 1; text-align: center; flex: 1; }
        .step .dot {
            width: 30px; height: 30px; margin: 0 auto; border-radius: 50%;
            background: #fff; border: 3px solid #cbd5e0;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s ease;
        }
        .step.active .dot { border-color: var(--brand-primary); background: var(--brand-primary); color: #fff; box-shadow: 0 0 0 5px rgba(13,110,253,0.18); }
        .step.done .dot { border-color: var(--brand-success); background: var(--brand-success); color: #fff; }
        .step .label { font-size: 0.68rem; margin-top: 0.35rem; color: var(--text-muted); }
        .step.active .label { color: var(--heading-color); font-weight: 600; }
        [data-bs-theme="dark"] .step-track::before { background: #334155; }
        [data-bs-theme="dark"] .step .dot { background: var(--surface); border-color: #475569; }

        .sisa-progress { height: 8px; border-radius: 8px; background: var(--surface-subtle); }
        .est-wait {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(255, 193, 7, 0.16);
            color: #996d00;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 2rem;
            padding: 0.25rem 0.7rem;
        }
        [data-bs-theme="dark"] .est-wait { color: #ffd666; background: rgba(255, 193, 7, 0.12); }

        .chart-range {
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 0.15rem;
            display: inline-flex;
            gap: 0.15rem;
        }
        .chart-range .btn-range {
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 600;
            border-radius: 2rem;
            padding: 0.3rem 0.8rem;
            transition: all 0.18s ease;
        }
        .chart-range .btn-range.active {
            background: var(--brand-primary);
            color: #fff;
            box-shadow: 0 3px 8px rgba(13, 110, 253, 0.35);
        }

        .next-step {
            border-left: 4px solid var(--brand-primary);
            background: var(--surface-subtle);
            border-radius: 0.6rem;
        }
        [data-bs-theme="dark"] .next-step { background: var(--surface-subtle); }

        .search-box {
            width: 220px;
            border-radius: 0.6rem;
        }

        .item-row {
            transition: background 0.15s ease, transform 0.15s ease;
            border-radius: 0.6rem;
        }
        .item-row:hover { background: rgba(13, 110, 253, 0.05); }
        [data-bs-theme="dark"] .item-row:hover { background: rgba(255, 255, 255, 0.04); }

        .toast-container { position: fixed; bottom: 1.25rem; right: 1.25rem; z-index: 2000; }
        .fade-slide { opacity: 0; transform: translateY(16px); transition: opacity 0.55s ease, transform 0.55s ease; }
        .fade-slide.in-view { opacity: 1; transform: translateY(0); }

        .refresh-spin { display: inline-block; transition: transform 0.6s ease; }
        .refresh-spin.spinning { transform: rotate(360deg); }

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
        $pasien = auth()->user()->pasien;
        $pendaftaranSemua = $pendaftaran ?? collect();
        $riwayatSemua = $riwayat_pemeriksaan ?? collect();

        $pendaftaranAktif = $pendaftaranSemua->filter(function ($p) {
            $st = $p->antrian?->status ?? $p->status;
            return !in_array($st, ['selesai', 'batal']);
        });

        $antrianTerbaru = $pendaftaranAktif->first();

        $namaUser = $pasien?->nama ?? auth()->user()->name ?? '';
        $inisial = collect(explode(' ', trim($namaUser)))->filter()->take(2)
            ->map(fn ($w) => strtoupper(mb_substr($w, 0, 1)))->implode('');

        $jam = (int) now()->format('G');
        $sapaan = ($jam >= 4 && $jam < 11) ? 'Selamat Pagi'
            : (($jam >= 11 && $jam < 15) ? 'Selamat Siang'
            : (($jam >= 15 && $jam < 18) ? 'Selamat Sore' : 'Selamat Malam'));

        $months6 = collect(range(5, 0))->map(fn ($i) => now()->copy()->subMonths($i));
        $months12 = collect(range(11, 0))->map(fn ($i) => now()->copy()->subMonths($i));
        $chartLabels6 = $months6->map(fn ($m) => $m->translatedFormat('M'))->values();
        $chartValues6 = $months6->map(fn ($m) => $riwayatSemua->filter(fn ($p) => $p->tanggal_periksa && $p->tanggal_periksa->format('Y-m') === $m->format('Y-m'))->count())->values();
        $chartLabels12 = $months12->map(fn ($m) => $m->translatedFormat('M'))->values();
        $chartValues12 = $months12->map(fn ($m) => $riwayatSemua->filter(fn ($p) => $p->tanggal_periksa && $p->tanggal_periksa->format('Y-m') === $m->format('Y-m'))->count())->values();
    @endphp

    {{-- Kartu sambutan --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 welcome-card" style="background-color:#0d6efd;color:#fff;">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>
        <div class="wave"></div>
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="welcome-avatar" title="{{ $pasien?->no_rm ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            {{ $inisial ?: 'P' }}
                        </div>
                        <div>
                            <span class="d-block text-white-50 small fw-semibold text-uppercase" style="letter-spacing:0.08em;">{{ $sapaan }}</span>
                            <h4 class="text-white fw-bold mb-0">Halo, {{ $namaUser }}</h4>
                            <span class="text-white-50 small">
                                @if ($pasien?->no_rm)
                                    No. RM: {{ $pasien->no_rm }} &middot;
                                @endif
                                Klinik Sehat
                            </span>
                        </div>
                    </div>
                    <p class="text-white-50 mb-3" style="max-width:540px;">
                        Kelola kunjungan, pantau nomor antrean secara real-time, dan cek riwayat pemeriksaan Anda—semuanya di satu tempat.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('pasien.portal.pendaftaran') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-plus-circle me-1"></i> Daftar Online
                        </a>
                        <a href="{{ route('pasien.portal.riwayat') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </a>
                        <a href="{{ route('pasien.portal.status') }}" class="btn quick-btn btn-sm px-3">
                            <i class="bi bi-hourglass-split me-1"></i> Status Antrean
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
                ['total-pendaftaran', 'Total Pendaftaran', $pendaftaranSemua->count(), 'bi-journal-plus', '#0d6efd', 'pendaftaranSection'],
                ['dalam-antrean', 'Dalam Antrean', $pendaftaranAktif->count(), 'bi-hourglass-split', '#ffc107', 'antrianSection'],
                ['riwayat-periksa', 'Riwayat Periksa', $riwayatSemua->count(), 'bi-clipboard2-pulse', '#198754', 'riwayatSection'],
            ];
        @endphp
        @foreach ($stats as [$id, $label, $value, $icon, $c, $target])
            <div class="col-sm-4">
                <div class="card stat-card shadow-sm h-100" style="--stat-color:{{ $c }};" data-scroll="{{ $target }}" title="Klik untuk menuju {{ $label }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="bi {{ $icon }} stat-watermark"></i>
                    <i class="bi bi-arrow-right-circle stat-go"></i>
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background:{{ $c }}1f;color:{{ $c }};"><i class="bi {{ $icon }}"></i></div>
                        <div>
                            <div class="fs-4 fw-bold counter" id="counter-{{ $id }}" data-target="{{ $value }}" style="color:var(--heading-color);">0</div>
                            <div class="text-muted small">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3" id="antrianSection">
        {{-- Nomor antrean + progress --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 h-100 overflow-hidden fade-slide">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-semibold mb-1"><i class="bi bi-list-ol text-info me-2"></i>Nomor Antrean Anda</h6>
                            <small class="text-muted" id="antrianSubtitle">
                                @if ($antrianTerbaru)
                                    Terakhir diperbarui {{ now()->format('H:i:s') }}
                                @else
                                    Belum ada antrean aktif
                                @endif
                            </small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnRefreshAntrian" title="Segarkan status antrean">
                            <i class="bi bi-arrow-clockwise refresh-spin" id="refreshIcon"></i>
                        </button>
                    </div>

                    <div id="antrianCard" class="mt-2">
                        @if ($antrianTerbaru)
                            @php
                                $noAntrian = $antrianTerbaru->antrian?->nomor_antrian ?? '-';
                                $tanggal = $antrianTerbaru->tanggal_daftar?->format('d-m-Y');
                                $dokter = $antrianTerbaru->jadwalDokter?->dokter?->nama ?? '-';
                                $poliklinik = $antrianTerbaru->jadwalDokter?->ruang ?? '-';
                                $st = $antrianTerbaru->antrian?->status ?? $antrianTerbaru->status;
                                $bahasa = ['terdaftar'=>'Mendaftar','menunggu'=>'Menunggu','dipanggil'=>'Dipanggil','diperiksa'=>'Diperiksa','selesai'=>'Selesai','batal'=>'Batal'];
                                $tahap = ['terdaftar'=>1,'menunggu'=>1,'dipanggil'=>2,'diperiksa'=>3,'selesai'=>4,'batal'=>0];
                                $stepAktif = $tahap[$st] ?? 0;
                                $steps = [['Daftar','bi-journal-plus'],['Tunggu','bi-hourglass-split'],['Dipanggil','bi-bell-fill'],['Selesai','bi-check-lg']];
                                $sisa = ($st === 'menunggu')
                                    ? \App\Models\Antrian::where('tanggal', $antrianTerbaru->tanggal_daftar->toDateString())
                                        ->where('pendaftaran_id', '!=', $antrianTerbaru->id)
                                        ->whereHas('pendaftaran', fn ($q) => $q->where('jadwal_dokter_id', $antrianTerbaru->jadwal_dokter_id))
                                        ->where('status', 'menunggu')
                                        ->where('nomor_antrian', '<', $antrianTerbaru->antrian?->nomor_antrian ?? '999')
                                        ->count()
                                    : 0;
                                $nomorInt = (int) ($antrianTerbaru->antrian?->nomor_antrian ?? 1);
                                $sisaPct = $sisa > 0
                                    ? max(5, (($nomorInt - 1 - $sisa) / max(1, $nomorInt - 1)) * 100)
                                    : 100;
                                $estimasi = ($st === 'menunggu') ? $sisa * 10 : 0;
                            @endphp
                            <div class="antrian-hero p-4 text-center">
                                <p class="text-muted mb-2 small fw-semibold text-uppercase" style="letter-spacing:0.08em;">Nomor Antrean</p>
                                <div class="antrian-score">
                                    <span class="glow"></span>
                                    <span class="hero-nomor" id="antrianNomor">{{ $noAntrian }}</span>
                                </div>
                                <div class="mt-3">
                                    <span class="badge badge-status-pulse px-3 py-2 fs-6 text-bg-{{ in_array($st, ['menunggu', 'terdaftar']) ? 'primary' : ($st === 'batal' ? 'danger' : 'info') }}" id="antrianBadge">
                                        <i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i><span id="antrianBadgeText">{{ $bahasa[$st] ?? $st }}</span>
                                    </span>
                                </div>
                            </div>

                            <div class="step-track" id="stepTrack">
                                @foreach ($steps as $i => [$namaStep])
                                    @php
                                        $stepClass = $i + 1 < $stepAktif ? 'done' : ($i + 1 === $stepAktif ? 'active' : '');
                                    @endphp
                                    <div class="step {{ $stepClass }}">
                                        <div class="dot">
                                            @if ($i + 1 < $stepAktif)
                                                <i class="bi bi-check small" style="font-size:0.8rem;"></i>
                                            @else
                                                <i class="bi {{ $steps[$i][1] }}" style="font-size:0.8rem;{{ $i + 1 > $stepAktif ? 'color:#cbd5e0;' : '' }}"></i>
                                            @endif
                                        </div>
                                        <div class="label">{{ $namaStep }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="rounded-3 p-3 mt-4" style="background:var(--surface-subtle);">
                                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                    <small class="text-muted"><i class="bi bi-people me-1"></i>Antrean di depan Anda</small>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-bold text-warning" id="sisaAntrean">{{ $sisa }} orang</span>
                                        <span class="est-wait">
                                            <i class="bi bi-hourglass-split"></i>
                                            <span id="estWait">
                                                @if ($st === 'menunggu')
                                                    {{ $sisa > 0 ? '± ' . $estimasi . ' menit lagi' : 'Anda berikutnya!' }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="progress sisa-progress" style="height:8px;">
                                    <div class="progress-bar progress-bar-animated" role="progressbar" id="sisaProgress"
                                         style="width:{{ $sisaPct }}%;background:var(--brand-primary);"></div>
                                </div>
                            </div>

                            <div class="rounded-3 p-3 text-center mt-3" style="background:var(--surface-subtle);">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i>Tanggal</small>
                                        <span class="fw-semibold" id="antrianTanggal">{{ $tanggal }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block"><i class="bi bi-person"></i>Dokter</small>
                                        <span class="fw-semibold" id="antrianDokter">{{ $dokter }}</span>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i>Poli / Ruang</small>
                                        <span class="fw-semibold" id="antrianPoli">{{ $poliklinik }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="next-step p-3 mt-3" id="nextStepBox">
                                <small class="text-muted d-block mb-1"><i class="bi bi-lightbulb me-1"></i>Langkah selanjutnya</small>
                                <span class="small fw-semibold" id="nextStepText">
                                    @if ($st === 'menunggu')
                                        Tunggu di ruang tunggu. Pantau nomor antrean Anda secara berkala.
                                    @elseif ($st === 'dipanggil')
                                        Antrean Anda sudah dipanggil. Segera menuju ruang periksa dokter.
                                    @elseif ($st === 'diperiksa')
                                        Anda sedang diperiksa. Siapkan keluhan dan dokumen yang diperlukan.
                                    @elseif ($st === 'selesai')
                                        Pemeriksaan selesai. Lihat riwayat pemeriksaan Anda.
                                    @elseif ($st === 'batal')
                                        Antrean dibatalkan. Silakan daftar ulang jika diperlukan.
                                    @else
                                        Pendaftaran berhasil. Silakan tunggu hingga antrean dipanggil.
                                    @endif
                                </span>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-pencil-square empty-bounce d-block fs-1 text-primary mb-3"></i>
                                <p class="text-muted mb-3">Belum ada antrean aktif saat ini.</p>
                                <a href="{{ route('pasien.portal.pendaftaran') }}" class="btn btn-brand text-white">
                                    <i class="bi bi-plus-circle me-1"></i> Daftar Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendaftaran terbaru --}}
        <div class="col-lg-7" id="pendaftaranSection">
            <div class="card card-table shadow-sm h-100 fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-journal-plus me-2 text-primary"></i>Pendaftaran Terbaru</h6>
                    @if ($pendaftaranSemua->isNotEmpty())
                        <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control search-box border-0 shadow-none" id="searchPendaftaran" placeholder="Cari pendaftaran...">
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @forelse ($pendaftaranSemua->take(6) as $p)
                        @php
                            $st = $p->antrian?->status ?? $p->status;
                            $map = ['terdaftar'=>['Terdaftar','primary'],'menunggu'=>['Menunggu','secondary'],'dipanggil'=>['Dipanggil','warning'],'diperiksa'=>['Diperiksa','info'],'selesai'=>['Selesai','success'],'batal'=>['Batal','danger']];
                            [$label,$color] = $map[$st] ?? [$st,'secondary'];
                        @endphp
                        <div class="d-flex align-items-center justify-content-between gap-3 border-bottom py-3 item-row pendaftaran-row">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon {{ $color === 'secondary' ? 'bg-secondary-subtle text-secondary' : 'bg-' . $color . '-subtle text-' . $color }}"
                                     style="width:40px;height:40px;border-radius:0.7rem;font-size:1.1rem;">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $p->no_pendaftaran }}</div>
                                    <div class="text-muted small">
                                        {{ $p->jadwalDokter?->dokter?->nama ?? '-' }}
                                        &middot;
                                        {{ $p->tanggal_daftar?->format('d-m-Y') }}
                                    </div>
                                </div>
                            </div>
                            <span class="badge text-bg-{{ $color }} badge-status">{{ $label }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox empty-bounce d-block fs-1 mb-2"></i>Belum ada pendaftaran.
                        </div>
                    @endforelse
                </div>
                <div class="card-footer bg-white border-0 pb-3 text-end">
                    <a href="{{ route('pasien.portal.pendaftaran') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i> Daftar Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat + statistik --}}
    <div class="row g-3 mt-0">
        <div class="col-lg-7" id="riwayatSection">
            <div class="card card-table shadow-sm h-100 fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-file-earmark-medical me-2 text-success"></i>Riwayat Pemeriksaan</h6>
                    <div class="d-flex gap-2 align-items-center">
                        @if ($riwayatSemua->isNotEmpty())
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control search-box border-0 shadow-none" id="searchRiwayat" placeholder="Cari riwayat...">
                            </div>
                        @endif
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#riwayatListCollapse" aria-expanded="true">
                            <i class="bi bi-eye me-1"></i><span class="btn-riwayat-collapse">Sembunyikan</span>
                        </button>
                        @if ($riwayatSemua->isNotEmpty())
                            <a href="{{ route('pasien.portal.riwayat') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        @endif
                    </div>
                </div>
                <div class="collapse show" id="riwayatListCollapse">
                    <div class="card-body">
                        @forelse ($riwayatSemua->take(6) as $p)
                            <div class="d-flex align-items-center justify-content-between gap-3 border-bottom py-3 item-row riwayat-row">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-success-subtle text-success" style="width:42px;height:42px;font-size:1.1rem;">
                                        <i class="bi bi-clipboard2-pulse"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $p->tanggal_periksa?->format('d-m-Y') }}</div>
                                        <div class="text-muted small">Dokter: {{ $p->dokter?->nama ?? '-' }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('rekam_medis.detail', $p) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-clipboard-x empty-bounce d-block fs-1 mb-2"></i>Belum ada riwayat pemeriksaan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-table shadow-sm h-100 fade-slide">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0"><i class="bi bi-bar-chart-fill me-2 text-info"></i>Statistik Kunjungan</h6>
                    <div class="chart-range" role="group" aria-label="Rentang waktu grafik">
                        <button type="button" class="btn-range active" id="btnRange6">6 bln</button>
                        <button type="button" class="btn-range" id="btnRange12">12 bln</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-end justify-content-between mb-3">
                        <div>
                            <div class="fs-3 fw-bold" style="color:var(--heading-color);">{{ $riwayatSemua->count() }}</div>
                            <small class="text-muted">total kunjungan</small>
                        </div>
                        <small class="text-muted" id="chartSubtitle"><i class="bi bi-calendar3 me-1"></i>6 bulan terakhir</small>
                    </div>
                    <div style="min-height:195px;position:relative;">
                        <canvas id="chartKunjungan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Container toast --}}
    <div class="toast-container" id="toastContainer"></div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ---------------------------------------------------------------
            // Tooltip
            // ---------------------------------------------------------------
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (el) { new bootstrap.Tooltip(el); });

            // ---------------------------------------------------------------
            // Live clock
            // ---------------------------------------------------------------
            function tickClock() {
                var el = document.getElementById('liveClock');
                if (el) el.textContent = new Date().toLocaleTimeString('id-ID');
            }
            tickClock();
            setInterval(tickClock, 1000);

            // ---------------------------------------------------------------
            // Animasi angka (counter)
            // ---------------------------------------------------------------
            var counters = document.querySelectorAll('.counter');
            counters.forEach(function (counter) {
                var target = parseInt(counter.getAttribute('data-target') || '0', 10);
                var duration = 800;
                var startTime = null;
                function updateCounter(ts) {
                    if (!startTime) startTime = ts;
                    var progress = Math.min((ts - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    counter.textContent = Math.floor(eased * target);
                    if (progress < 1) requestAnimationFrame(updateCounter);
                    else counter.textContent = target;
                }
                requestAnimationFrame(updateCounter);
            });

            // ---------------------------------------------------------------
            // Stat card -> scroll ke section terkait
            // ---------------------------------------------------------------
            document.querySelectorAll('.stat-card[data-scroll]').forEach(function (card) {
                card.addEventListener('click', function () {
                    var target = document.getElementById(card.dataset.scroll);
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // ---------------------------------------------------------------
            // Animasi fade-slide saat scroll
            // ---------------------------------------------------------------
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

            // ---------------------------------------------------------------
            // Toast helper
            // ---------------------------------------------------------------
            function showToast(message, icon, color) {
                var container = document.getElementById('toastContainer');
                var id = 'toast-' + Date.now();
                var html =
                    '<div class="toast align-items-center border-0 shadow" id="' + id + '" role="alert">' +
                    '  <div class="d-flex">' +
                    '    <div class="toast-body text-white bg-' + color + ' d-flex align-items-center rounded-start">' +
                    '      <i class="bi ' + icon + ' me-2"></i>' + message +
                    '    </div>' +
                    '    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
                    '  </div>' +
                    '</div>';
                container.insertAdjacentHTML('beforeend', html);
                var el = document.getElementById(id);
                var toast = new bootstrap.Toast(el, { delay: 3500 });
                toast.show();
                el.addEventListener('hidden.bs.toast', function () { el.remove(); });
            }

            // ---------------------------------------------------------------
            // Logika status antrean (nama, urutan tahap, warna, saran)
            // ---------------------------------------------------------------
            var STATUS = {
                terdaftar: { label: 'Mendaftar', badge: 'primary', step: 1 },
                menunggu: { label: 'Menunggu', badge: 'primary', step: 1 },
                dipanggil: { label: 'Dipanggil', badge: 'warning', step: 2 },
                diperiksa: { label: 'Diperiksa', badge: 'info', step: 3 },
                selesai: { label: 'Selesai', badge: 'success', step: 4 },
                batal:    { label: 'Batal', badge: 'danger', step: 0 }
            };
            var STEPS = [['Daftar', 'bi-journal-plus'], ['Tunggu', 'bi-hourglass-split'], ['Dipanggil', 'bi-bell-fill'], ['Selesai', 'bi-check-lg']];

            function nextStepText(status) {
                var msg = {
                    menunggu: 'Tunggu di ruang tunggu. Pantau nomor antrean Anda secara berkala.',
                    dipanggil: 'Antrean Anda sudah dipanggil. Segera menuju ruang periksa dokter.',
                    diperiksa: 'Anda sedang diperiksa. Siapkan keluhan dan dokumen yang diperlukan.',
                    selesai: 'Pemeriksaan selesai. Lihat riwayat pemeriksaan Anda.',
                    batal: 'Antrean dibatalkan. Silakan daftar ulang jika diperlukan.'
                };
                return msg[status] || 'Pendaftaran berhasil. Silakan tunggu hingga antrean dipanggil.';
            }

            function buildSteps(step) {
                var html = '<div class="step-track" id="stepTrack">';
                STEPS.forEach(function (s, i) {
                    var cls = (i + 1 < step) ? 'done' : (i + 1 === step ? 'active' : '');
                    var inner;
                    if (i + 1 < step) inner = '<i class="bi bi-check small" style="font-size:0.8rem;"></i>';
                    else inner = '<i class="bi ' + s[1] + '" style="font-size:0.8rem;' + (i + 1 > step ? 'color:#cbd5e0;' : '') + '"></i>';
                    html += '<div class="step ' + cls + '"><div class="dot">' + inner + '</div><div class="label">' + s[0] + '</div></div>';
                });
                return html + '</div>';
            }

            // ---------------------------------------------------------------
            // Render antrean (dipanggil juga setelah fetch)
            // ---------------------------------------------------------------
            var lastStatus = '';
            function renderAntrian(data) {
                var card = document.getElementById('antrianCard');
                if (!card) return;

                if (!data.found) {
                    card.innerHTML =
                        '<div class="text-center py-5">' +
                        '  <i class="bi bi-pencil-square empty-bounce d-block fs-1 text-primary mb-3"></i>' +
                        '  <p class="text-muted mb-3">Belum ada antrean aktif saat ini.</p>' +
                        '  <a href="{{ route('pasien.portal.pendaftaran') }}" class="btn btn-brand text-white"><i class="bi bi-plus-circle me-1"></i> Daftar Sekarang</a>' +
                        '</div>';
                    return;
                }

                var a = data.antrian;
                var info = STATUS[a.status] || { label: a.status, badge: 'secondary', step: 0 };
                var nomorInt = parseInt(a.nomor_antrian, 10) || 0;
                var sisa = parseInt(a.sisa, 10) || 0;
                var totalBefore = Math.max(nomorInt - 1, 1);
                var pct = Math.round((1 - sisa / totalBefore) * 100);
                if (pct < 0) pct = 0;
                if (a.status === 'batal') pct = 100;
                if (a.status === 'selesai') pct = 100;

                var barColor = { primary: 'var(--brand-primary)', warning: '#ffc107', info: '#0dcaf0', success: 'var(--brand-success)' }[info.badge] || 'var(--brand-primary)';
                var estText = (a.status === 'menunggu')
                    ? (sisa > 0 ? '± ' + (sisa * 10) + ' menit lagi' : 'Anda berikutnya!')
                    : '-';

                card.innerHTML =
                    '<div class="antrian-hero p-4 text-center">' +
                    '  <p class="text-muted mb-2 small fw-semibold text-uppercase" style="letter-spacing:0.08em;">Nomor Antrean</p>' +
                    '  <div class="antrian-score"><span class="glow"></span>' +
                    '    <span class="hero-nomor" id="antrianNomor">' + a.nomor_antrian + '</span>' +
                    '  </div>' +
                    '  <div class="mt-3"><span class="badge badge-status-pulse px-3 py-2 fs-6 text-bg-' + info.badge + '" id="antrianBadge">' +
                    '    <i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i><span id="antrianBadgeText">' + info.label + '</span></span></div>' +
                    '</div>' +
                    buildSteps(info.step) +
                    '<div class="rounded-3 p-3 mt-4" style="background:var(--surface-subtle);">' +
                    '  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">' +
                    '    <small class="text-muted"><i class="bi bi-people me-1"></i>Antrean di depan Anda</small>' +
                    '    <div class="d-flex align-items-center gap-2 flex-wrap">' +
                    '      <span class="fw-bold text-warning" id="sisaAntrean">' + (a.status === 'menunggu' ? sisa + ' orang' : '-') + '</span>' +
                    '      <span class="est-wait"><i class="bi bi-hourglass-split"></i><span id="estWait">' + estText + '</span></span>' +
                    '    </div>' +
                    '  </div>' +
                    '  <div class="progress sisa-progress" style="height:8px;">' +
                    '    <div class="progress-bar progress-bar-animated" id="sisaProgress" role="progressbar" style="width:' + pct + '%;background:' + barColor + ';"></div>' +
                    '  </div>' +
                    '</div>' +
                    '<div class="rounded-3 p-3 text-center mt-3" style="background:var(--surface-subtle);">' +
                    '  <div class="row g-2">' +
                    '    <div class="col-6"><small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i>Tanggal</small><span class="fw-semibold" id="antrianTanggal">' + a.tanggal + '</span></div>' +
                    '    <div class="col-6"><small class="text-muted d-block"><i class="bi bi-person"></i>Dokter</small><span class="fw-semibold" id="antrianDokter">' + a.dokter + '</span></div>' +
                    '    <div class="col-12 mt-2"><small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i>Poli / Ruang</small><span class="fw-semibold" id="antrianPoli">' + a.ruang + '</span></div>' +
                    '  </div>' +
                    '</div>' +
                    '<div class="next-step p-3 mt-3">' +
                    '  <small class="text-muted d-block mb-1"><i class="bi bi-lightbulb me-1"></i>Langkah selanjutnya</small>' +
                    '  <span class="small fw-semibold" id="nextStepText">' + nextStepText(a.status) + '</span>' +
                    '</div>';

                // Notifikasi perubahan status
                if (lastStatus && lastStatus !== a.status) {
                    showToast('Status antrean: ' + info.label, 'bi-bell-fill', info.badge);
                }
                lastStatus = a.status;
            }

            // ---------------------------------------------------------------
            // Fetch status antrean dari server
            // ---------------------------------------------------------------
            var refreshUrl = @json(route('pasien.portal.antrian.refresh'));

            function loadAntrian(silent) {
                return fetch(refreshUrl, { headers: { 'Accept': 'application/json' } })
                    .then(function (r) { if (!r.ok) throw new Error('Gagal memuat'); return r.json(); })
                    .then(function (data) {
                        renderAntrian(data);
                        var sub = document.getElementById('antrianSubtitle');
                        if (sub) sub.textContent = 'Terakhir diperbarui ' + new Date().toLocaleTimeString('id-ID');
                        return data;
                    })
                    .catch(function () {
                        if (!silent) showToast('Gagal memperbarui status antrean.', 'bi-exclamation-triangle-fill', 'danger');
                    });
            }

            // Sinkronisasi awal + polling otomatis
            loadAntrian(true);
            setInterval(function () { loadAntrian(true); }, 25000);

            // Tombol segarkan manual
            var btnRefresh = document.getElementById('btnRefreshAntrian');
            var icon = document.getElementById('refreshIcon');
            if (btnRefresh) {
                btnRefresh.addEventListener('click', function () {
                    icon.classList.add('spinning');
                    loadAntrian(false).finally(function () {
                        setTimeout(function () { icon.classList.remove('spinning'); }, 600);
                    });
                });
            }

            // ---------------------------------------------------------------
            // Collapse riwayat label
            // ---------------------------------------------------------------
            var btnCollapse = document.querySelector('[data-bs-target="#riwayatListCollapse"]');
            if (btnCollapse) {
                btnCollapse.addEventListener('click', function () {
                    var collapseEl = document.getElementById('riwayatListCollapse');
                    setTimeout(function () {
                        var label = btnCollapse.querySelector('.btn-riwayat-collapse');
                        var hidden = collapseEl.classList.contains('show');
                        if (label) label.textContent = hidden ? 'Tampilkan' : 'Sembunyikan';
                    }, 200);
                });
            }

            // ---------------------------------------------------------------
            // Pencarian pada daftar
            // ---------------------------------------------------------------
            function filterList(inputId, rowClass) {
                var input = document.getElementById(inputId);
                if (!input) return;
                input.addEventListener('input', function () {
                    var q = input.value.toLowerCase();
                    document.querySelectorAll('.' + rowClass).forEach(function (row) {
                        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
                    });
                });
            }
            filterList('searchPendaftaran', 'pendaftaran-row');
            filterList('searchRiwayat', 'riwayat-row');

            // ---------------------------------------------------------------
            // Chart statistik kunjungan (toggle 6/12 bulan)
            // ---------------------------------------------------------------
            if (typeof Chart !== 'undefined' && document.getElementById('chartKunjungan')) {
                var chartData = {
                    6: { labels: @json($chartLabels6), values: @json($chartValues6) },
                    12: { labels: @json($chartLabels12), values: @json($chartValues12) }
                };
                var tickColor = getComputedStyle(document.documentElement).getPropertyValue('--heading-color').trim() || '#0b1b33';
                var ctx = document.getElementById('chartKunjungan').getContext('2d');
                var gradient = ctx.createLinearGradient(0, 0, 0, 260);
                gradient.addColorStop(0, 'rgba(13, 110, 253, 0.95)');
                gradient.addColorStop(1, 'rgba(56, 178, 172, 0.55)');

                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData[6].labels,
                        datasets: [{
                            label: 'Kunjungan',
                            data: chartData[6].values,
                            backgroundColor: gradient,
                            hoverBackgroundColor: 'rgba(13, 110, 253, 1)',
                            borderRadius: 8,
                            maxBarThickness: 34
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: tickColor },
                                grid: { color: 'rgba(148, 163, 184, 0.2)' }
                            },
                            x: {
                                ticks: { color: tickColor, maxRotation: 0, autoSkip: true },
                                grid: { display: false }
                            }
                        }
                    }
                });

                var btn6 = document.getElementById('btnRange6');
                var btn12 = document.getElementById('btnRange12');
                var chartSub = document.getElementById('chartSubtitle');
                function setRange(n) {
                    chart.data.labels = chartData[n].labels;
                    chart.data.datasets[0].data = chartData[n].values;
                    chart.update();
                    if (chartSub) chartSub.innerHTML = '<i class="bi bi-calendar3 me-1"></i>' + n + ' bulan terakhir';
                    if (btn6) btn6.classList.toggle('active', n === 6);
                    if (btn12) btn12.classList.toggle('active', n === 12);
                }
                if (btn6) btn6.addEventListener('click', function () { setRange(6); });
                if (btn12) btn12.addEventListener('click', function () { setRange(12); });

                function applyChartColors() {
                    var heading = getComputedStyle(document.documentElement).getPropertyValue('--heading-color').trim() || '#0b1b33';
                    var border = getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim() || 'rgba(148, 163, 184, 0.2)';
                    chart.options.scales.y.ticks.color = heading;
                    chart.options.scales.x.ticks.color = heading;
                    chart.options.scales.y.grid.color = border;
                    chart.update();
                }
                new MutationObserver(function (muts) {
                    muts.forEach(function (m) {
                        if (m.attributeName === 'data-bs-theme') applyChartColors();
                    });
                }).observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
            }
        });
    </script>
@endpush