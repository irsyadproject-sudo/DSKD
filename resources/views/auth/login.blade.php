<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Sehat</title>
    <script>
        (function () {
            var t = 'light';
            try { t = localStorage.getItem('theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'); } catch (e) {}
            document.documentElement.setAttribute('data-bs-theme', t);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg-dark: #0b1628;
            --bg-gradient-1: #0b1628;
            --bg-gradient-2: #12304f;
            --bg-gradient-3: #0d1f33;
            --surface: #ffffff;
            --surface-hover: #f8faff;
            --surface-border: #e4e9f2;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --brand-blue: #3b82f6;
            --brand-blue-hover: #2563eb;
            --brand-blue-soft: #eff6ff;
            --brand-teal: #14b8a6;
            --brand-teal-soft: #f0fdfa;
            --accent-glow: rgba(59, 130, 246, 0.12);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.04);
            --input-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        [data-bs-theme="dark"] {
            --bg-gradient-1: #0b1628;
            --bg-gradient-2: #131f38;
            --bg-gradient-3: #0a1220;
            --surface: #141f33;
            --surface-hover: #1a2840;
            --surface-border: rgba(255,255,255,0.08);
            --text-primary: #e8edf4;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --brand-blue-soft: rgba(59,130,246,0.1);
            --brand-teal-soft: rgba(20,184,166,0.08);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(0, 0, 0, 0.15);
            --input-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            background: var(--bg-gradient-1);
            color: var(--text-primary);
        }

        .login-split { display: flex; width: 100%; min-height: 100vh; }

        /* ===================== LEFT PANEL ===================== */
        .login-brand {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 15% 20%, rgba(59,130,246,0.35) 0%, transparent 45%),
                radial-gradient(circle at 85% 25%, rgba(20,184,166,0.28) 0%, transparent 40%),
                radial-gradient(circle at 60% 85%, rgba(99,102,241,0.25) 0%, transparent 45%),
                linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 55%, var(--bg-gradient-3) 100%);
            color: #fff;
            padding: 3.5rem;
        }

        /* Medical cross pattern overlay */
        .login-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(circle at 30% 30%, black 0%, transparent 70%);
            -webkit-mask-image: radial-gradient(circle at 30% 30%, black 0%, transparent 70%);
            pointer-events: none;
        }

        /* Floating blurred orbs */
        .login-brand .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.3;
            pointer-events: none;
        }
        .login-brand .orb-1 { width: 300px; height: 300px; background: #3b82f6; top: -80px; right: -80px; animation: floatGlow 14s ease-in-out infinite alternate; }
        .login-brand .orb-2 { width: 260px; height: 260px; background: #14b8a6; bottom: -70px; left: -40px; animation: floatGlow 11s ease-in-out infinite alternate-reverse; }
        .login-brand .orb-3 { width: 180px; height: 180px; background: #8b5cf6; top: -30px; left: 10%; animation: floatGlow 9s ease-in-out infinite alternate; }
        @keyframes floatGlow {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-30px) scale(1.08); }
        }

        .login-brand .brand-content { position: relative; z-index: 3; max-width: 430px; text-align: center; }

        .brand-topline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(6px);
            padding: 0.4rem 0.9rem;
            border-radius: 2rem;
            margin-bottom: 1.5rem;
        }
        .brand-topline .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,0.25);
            animation: blink 1.6s ease-in-out infinite;
        }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.35; } }

        .brand-icon {
            width: 78px; height: 78px; border-radius: 1.4rem;
            background: linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-teal) 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.1rem; color: #fff; margin: 0 auto 1.5rem;
            box-shadow: 0 10px 34px rgba(59,130,246,0.4);
        }
        .login-brand h1 {
            font-size: 2.35rem; font-weight: 800; letter-spacing: -0.02em;
            margin-bottom: 0.6rem; line-height: 1.15;
        }
        .login-brand .tagline {
            font-size: 1rem; color: rgba(255,255,255,0.68);
            line-height: 1.65; margin-bottom: 2.25rem;
        }

        .feature-list { list-style: none; padding: 0; margin: 0; display: inline-block; text-align: left; }
        .feature-list li {
            display: flex; align-items: flex-start; justify-content: center; gap: 0.8rem;
            padding: 0.62rem 0; font-size: 0.88rem; color: rgba(255,255,255,0.82);
            text-align: left;
        }
        .feature-list li > span:last-child { flex: 1; min-width: 240px; text-align: left; }
        .feature-list li .f-icon {
            width: 30px; height: 30px; border-radius: 0.6rem; flex-shrink: 0;
            background: rgba(20,184,166,0.16); border: 1px solid rgba(20,184,166,0.28);
            display: flex; align-items: center; justify-content: center;
            color: #5eead4; font-size: 0.95rem; margin-top: 1px;
        }

        /* Floating mini stat cards */
        .stat-floaters {
            position: absolute; inset: 0; z-index: 2; pointer-events: none;
        }
        .float-card {
            position: absolute;
            display: flex; align-items: center; gap: 0.75rem;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1rem;
            padding: 0.85rem 1.1rem;
            box-shadow: 0 18px 40px rgba(0,0,0,0.22);
            animation: floatCard 7s ease-in-out infinite;
        }
        .float-card .fc-icon {
            width: 38px; height: 38px; border-radius: 0.8rem; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
        }
        .float-card .fc-label { font-size: 0.68rem; color: rgba(255,255,255,0.6); letter-spacing: 0.02em; }
        .float-card .fc-value { font-size: 0.98rem; font-weight: 700; line-height: 1.15; color: #fff; }
        .fc-1 { top: 12%; right: 8%; animation-delay: 0s; }
        .fc-2 { top: 10%; left: 6%; animation-delay: 1.2s; }
        .fc-3 { bottom: 22%; right: 10%; animation-delay: 2.4s; }
        .fc-blue .fc-icon { background: rgba(59,130,246,0.25); color: #93c5fd; }
        .fc-teal .fc-icon { background: rgba(20,184,166,0.25); color: #5eead4; }
        .fc-violet .fc-icon { background: rgba(139,92,246,0.25); color: #c4b5fd; }
        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-14px); }
        }

        .brand-footer {
            position: absolute; bottom: 2rem; left: 3.5rem; right: 3.5rem; z-index: 3;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem; font-size: 0.76rem; color: rgba(255,255,255,0.45);
        }
        .brand-footer .cert-strip {
            display: flex; flex-wrap: wrap; gap: 0.75rem 1.5rem;
        }
        .brand-footer .cert-strip span { display: flex; align-items: center; gap: 0.4rem; }
        .brand-footer .cert-strip i { color: rgba(74,222,128,0.7); }
        .brand-footer .live-clock {
            display: flex; align-items: center; gap: 0.45rem;
            font-variant-numeric: tabular-nums; color: rgba(255,255,255,0.6);
        }
        .brand-footer .live-clock i { color: rgba(59,130,246,0.7); }

        /* ===================== RIGHT PANEL ===================== */
        .login-form-panel {
            width: 500px; min-width: 500px;
            display: flex; flex-direction: column; justify-content: center;
            padding: 3rem 3.25rem;
            background: var(--surface);
            overflow-y: auto; position: relative;
        }
        [data-bs-theme="dark"] .login-form-panel { background: var(--surface); }
        .login-form-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--brand-blue), var(--brand-teal), #8b5cf6, var(--brand-blue));
            background-size: 300% 100%;
            animation: accentSlide 8s linear infinite;
        }
        @keyframes accentSlide { 0% { background-position: 0% 0; } 100% { background-position: 300% 0; } }

        .form-header { margin-bottom: 2rem; }
        .form-header .mobile-brand { display: none; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; }
        .form-header .mobile-brand .mob-icon {
            width: 44px; height: 44px; border-radius: 0.85rem;
            background: linear-gradient(135deg, var(--brand-blue), var(--brand-teal));
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }
        .form-header .mobile-brand span { font-weight: 700; font-size: 1.1rem; color: var(--text-primary); }

        .form-header .hello-badge {
            display: inline-flex; align-items: center; gap: 0.45rem;
            font-size: 0.72rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--brand-blue);
            background: var(--brand-blue-soft);
            padding: 0.35rem 0.85rem; border-radius: 2rem; margin-bottom: 1rem;
        }
        .form-header h2 { font-size: 1.65rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.4rem; }
        .form-header p { font-size: 0.88rem; color: var(--text-secondary); margin: 0; }

        .form-section-title {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.78rem; font-weight: 600; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1.35rem;
        }
        .form-section-title::after {
            content: ''; flex: 1; height: 1px; background: var(--surface-border);
        }

        .form-floating-label { position: relative; margin-bottom: 1.25rem; }
        .form-floating-label label {
            position: absolute; top: 50%; left: 0.95rem; transform: translateY(-50%);
            font-size: 0.85rem; color: var(--text-muted); pointer-events: none;
            transition: all 0.2s ease; background: var(--surface); padding: 0 0.35rem;
        }
        .form-floating-label .form-control {
            height: 50px; border: 1.5px solid var(--surface-border);
            border-radius: 0.8rem; font-size: 0.9rem; color: var(--text-primary);
            background: var(--surface); padding: 0 2.9rem 0 0.95rem;
            box-shadow: var(--input-shadow); transition: all 0.2s ease;
        }
        .form-floating-label .form-control:focus {
            border-color: var(--brand-blue); box-shadow: 0 0 0 3px var(--accent-glow), var(--input-shadow);
        }
        .form-floating-label .form-control:focus + label,
        .form-floating-label .form-control:not(:placeholder-shown) + label {
            top: -0.4rem; font-size: 0.72rem; font-weight: 500; color: var(--brand-blue);
        }
        .form-floating-label .form-control.is-invalid { border-color: #ef4444; }
        .form-floating-label .toggle-pass {
            position: absolute; right: 0.8rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-muted); cursor: pointer;
            padding: 0.25rem; font-size: 1.05rem; transition: color 0.15s; z-index: 5;
        }
        .form-floating-label .toggle-pass:hover { color: var(--text-secondary); }
        .form-floating-label .input-icon {
            position: absolute; right: 2.9rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 0.95rem; pointer-events: none; z-index: 5;
        }

        .form-options {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.4rem; flex-wrap: wrap; gap: 0.5rem;
        }
        .form-check-custom { display: flex; align-items: center; gap: 0.5rem; }
        .form-check-custom input[type="checkbox"] {
            width: 17px; height: 17px; border: 1.5px solid var(--surface-border);
            border-radius: 4px; cursor: pointer; accent-color: var(--brand-blue);
        }
        .form-check-custom label { font-size: 0.82rem; color: var(--text-secondary); cursor: pointer; margin: 0; }
        .forgot-link { font-size: 0.82rem; color: var(--brand-blue); text-decoration: none; font-weight: 500; transition: color 0.15s; }
        .forgot-link:hover { color: var(--brand-blue-hover); }

        .btn-login {
            width: 100%; height: 50px; border: none; border-radius: 0.8rem;
            font-size: 0.92rem; font-weight: 600; letter-spacing: 0.01em;
            background: linear-gradient(135deg, var(--brand-blue), #4f7cf7);
            color: #fff; cursor: pointer; transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(59,130,246,0.3);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-login:hover {
            transform: translateY(-1px); box-shadow: 0 6px 26px rgba(59,130,246,0.42);
            background: linear-gradient(135deg, var(--brand-blue-hover), #4f7cf7);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-login .spinner-border { width: 1.1rem; height: 1.1rem; border-width: 2px; display: none; }
        .btn-login.loading .spinner-border { display: inline-block; }
        .btn-login.loading .btn-text { display: none; }
        .btn-login.loading .btn-loading { display: inline; }
        .btn-login .btn-loading { display: none; }

        .alert-custom {
            border-radius: 0.75rem; border: none; font-size: 0.84rem;
            padding: 0.85rem 1rem; display: flex; align-items: flex-start; gap: 0.65rem;
        }
        .alert-custom.alert-danger { background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444; }
        .alert-custom.alert-danger i { color: #ef4444; font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        .alert-custom.alert-success { background: #f0fdf4; color: #166534; border-left: 3px solid #22c55e; }
        .alert-custom.alert-success i { color: #22c55e; font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        [data-bs-theme="dark"] .alert-custom.alert-danger { background: rgba(239,68,68,0.08); color: #fca5a5; }
        [data-bs-theme="dark"] .alert-custom.alert-success { background: rgba(34,197,94,0.08); color: #86efac; }

        .security-note {
            display: flex; align-items: center; justify-content: center; gap: 0.45rem;
            margin-top: 1.4rem; font-size: 0.74rem; color: var(--text-muted);
        }
        .security-note i { color: var(--brand-teal); }

        .register-prompt {
            display: flex; align-items: center; justify-content: center; gap: 0.35rem;
            margin: 1.25rem 0 0; font-size: 0.86rem; color: var(--text-secondary);
        }
        .register-prompt a {
            color: var(--brand-blue); font-weight: 600; text-decoration: none; transition: color 0.15s;
        }
        .register-prompt a:hover { color: var(--brand-blue-hover); }

        .theme-toggle {
            position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1060;
            width: 40px; height: 40px; border: none; border-radius: 0.65rem;
            background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.75);
            font-size: 1rem; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s; backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.14);
        }
        .theme-toggle:hover { background: rgba(255,255,255,0.18); color: #fff; }

        /* In light mode the right panel is white, so switch to a dark glass style */
        [data-bs-theme="light"] .theme-toggle {
            background: rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(15, 23, 42, 0.14);
            color: #334155;
        }
        [data-bs-theme="light"] .theme-toggle:hover {
            background: rgba(15, 23, 42, 0.1);
            color: #0f172a;
        }

        /* Responsive */
        @media (max-width: 960px) {
            .login-brand { display: none; }
            .login-form-panel { width: 100%; min-width: 100%; padding: 2rem 1.5rem; }
            .form-header .mobile-brand { display: flex; }
            body { overflow-y: auto; }
            .login-split { align-items: center; }
        }
        @media (max-width: 480px) {
            .login-form-panel { padding: 1.5rem 1.25rem; }
            .form-header h2 { font-size: 1.35rem; }
        }
    </style>
</head>
<body>
    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">
        <i class="bi bi-moon-stars-fill"></i>
    </button>

    <div class="login-split">
        {{-- Left panel --}}
        <div class="login-brand">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>

            <div class="stat-floaters">
                <div class="float-card fc-blue fc-1">
                    <div class="fc-icon"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="fc-label">Pasien Terdaftar</div>
                        <div class="fc-value">12.450+</div>
                    </div>
                </div>
                <div class="float-card fc-teal fc-2">
                    <div class="fc-icon"><i class="bi bi-person-badge-fill"></i></div>
                    <div>
                        <div class="fc-label">Dokter Spesialis</div>
                        <div class="fc-value">38 Orang</div>
                    </div>
                    
                </div>
                <div class="float-card fc-violet fc-3">
                    <div class="fc-icon"><i class="bi bi-speedometer2"></i></div>
                    <div>
                        <div class="fc-label">Sistem Online</div>
                        <div class="fc-value">Uptime 99,9%</div>
                    </div>
                </div>
            </div>

            <div class="brand-content">
                <div class="brand-topline">
                    <span class="dot"></span>
                    Sistem Informasi Klinik Terpadu
                </div>
                <div class="brand-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h1>Klinik Sehat</h1>
                <p class="tagline">Sistem informasi terpadu untuk manajemen klinik yang efisien, cepat, dan terpercaya.</p>
                <ul class="feature-list">
                    <li>
                        <span class="f-icon"><i class="bi bi-clipboard2-pulse"></i></span>
                        <span>Manajemen pendaftaran & antrean pasien</span>
                    </li>
                    <li>
                        <span class="f-icon"><i class="bi bi-file-earmark-medical"></i></span>
                        <span>Pencatatan rekam medis & resep digital</span>
                    </li>
                    <li>
                        <span class="f-icon"><i class="bi bi-graph-up-arrow"></i></span>
                        <span>Laporan keuangan & struk otomatis</span>
                    </li>
                    <li>
                        <span class="f-icon"><i class="bi bi-shield-lock"></i></span>
                        <span>Portal akses khusus dokter & pasien</span>
                    </li>
                </ul>
            </div>

            <div class="brand-footer">
                <div class="cert-strip">
                    <span><i class="bi bi-patch-check-fill"></i> Terdaftar di Dinkes</span>
                    <span><i class="bi bi-shield-lock"></i> Terenkripsi SSL</span>
                    <span><i class="bi bi-cpu"></i> v2.0 &middot; 2026</span>
                </div>
                <div class="live-clock" id="liveClock">
                    <i class="bi bi-clock"></i>
                    <span id="clockText">--:--:--</span>
                </div>
            </div>
        </div>

        {{-- Right panel - Login form --}}
        <div class="login-form-panel">
            <div class="form-header">
                <div class="mobile-brand">
                    <div class="mob-icon">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <span>Klinik Sehat</span>
                </div>
                <div class="hello-badge">
                    <i class="bi bi-person-check"></i> Akses Terbatas
                </div>
                <h2>Selamat Datang kembali</h2>
                <p>Masuk ke akun Anda untuk mengakses sistem klinik</p>
            </div>

            {{-- Status Alert (e.g. after password reset) --}}
            @if (session('status'))
                <div class="alert-custom alert-success mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert-custom alert-danger mb-3">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-section-title">Masuk dengan akun</div>

                <div class="form-floating-label">
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="email">
                    <label for="email">Alamat Email</label>
                    <i class="bi bi-envelope input-icon"></i>
                </div>

                <div class="form-floating-label">
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required autocomplete="current-password">
                    <label for="password">Password</label>
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Tampilkan password">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="form-options">
                    <div class="form-check-custom">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                    </span>
                    <span class="btn-loading">
                        <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                        Memproses...
                    </span>
                </button>
            </form>

            <div class="register-prompt">
                <span>Belum punya akun?</span>
                <a href="{{ route('register') }}">Daftar sebagai Pasien</a>
            </div>

            <div class="security-note">
                <i class="bi bi-shield-check"></i>
                <span>Sesi Anda aman & data dienkripsi penuh</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle
        (function () {
            var btn = document.getElementById('themeToggle');
            var icon = btn.querySelector('i');
            function syncIcon() {
                var d = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                icon.className = d ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            }
            btn.addEventListener('click', function () {
                var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                try { localStorage.setItem('theme', next); } catch (e) {}
                syncIcon();
            });
            syncIcon();
        })();

        // Toggle password visibility
        function togglePassword() {
            var pwd = document.getElementById('password');
            var icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function () {
            var btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Live clock
        (function () {
            var el = document.getElementById('clockText');
            if (!el) return;
            function tick() {
                var d = new Date();
                var pad = function (n) { return String(n).padStart(2, '0'); };
                el.textContent = d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short' }) +
                    ' \u2022 ' + pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
            }
            tick();
            setInterval(tick, 1000);
        })();
    </script>
</body>
</html>