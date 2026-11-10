<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Klinik Sehat</title>
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
            --bg-gradient-2: #162544;
            --bg-gradient-3: #0f2027;
            --surface: #ffffff;
            --surface-border: #e4e9f2;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --brand-blue: #3b82f6;
            --brand-blue-hover: #2563eb;
            --brand-blue-soft: #eff6ff;
            --brand-teal: #14b8a6;
            --accent-glow: rgba(59, 130, 246, 0.12);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.04);
            --input-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        [data-bs-theme="dark"] {
            --bg-gradient-1: #0b1628;
            --bg-gradient-2: #131f38;
            --bg-gradient-3: #0a1220;
            --surface: #141f33;
            --surface-border: rgba(255,255,255,0.08);
            --text-primary: #e8edf4;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --brand-blue-soft: rgba(59,130,246,0.1);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(0, 0, 0, 0.15);
            --input-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 50%, var(--bg-gradient-3) 100%);
            padding: 2rem 1rem;
            color: var(--text-primary);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(59,130,246,0.1) 0%, transparent 50%);
            animation: subtlePulse 12s ease-in-out infinite alternate;
        }
        @keyframes subtlePulse {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.05) rotate(3deg); }
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: var(--surface);
            border-radius: 1.25rem;
            padding: 2.5rem;
            position: relative;
            z-index: 2;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--surface-border);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 1.5rem;
        }
        .card-icon.blue {
            background: var(--brand-blue-soft);
            color: var(--brand-blue);
        }
        .card-icon.green {
            background: rgba(20,184,166,0.1);
            color: var(--brand-teal);
        }

        .card-title {
            font-size: 1.35rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.4rem;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }
        .card-subtitle {
            font-size: 0.88rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        .form-floating-label {
            position: relative;
            margin-bottom: 1.25rem;
        }
        .form-floating-label label {
            position: absolute;
            top: 50%;
            left: 0.9rem;
            transform: translateY(-50%);
            font-size: 0.85rem;
            color: var(--text-muted);
            pointer-events: none;
            transition: all 0.2s ease;
            background: var(--surface);
            padding: 0 0.35rem;
        }
        .form-floating-label .form-control {
            height: 48px;
            border: 1.5px solid var(--surface-border);
            border-radius: 0.75rem;
            font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--surface);
            padding: 0 0.9rem;
            box-shadow: var(--input-shadow);
            transition: all 0.2s ease;
        }
        .form-floating-label .form-control:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 3px var(--accent-glow), var(--input-shadow);
        }
        .form-floating-label .form-control:focus + label,
        .form-floating-label .form-control:not(:placeholder-shown) + label {
            top: -0.35rem;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--brand-blue);
        }

        .btn-primary-custom {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.92rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--brand-blue), #4f7cf7);
            color: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(59,130,246,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(59,130,246,0.4);
        }
        .btn-primary-custom:disabled { opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-primary-custom .spinner-border { width: 1.1rem; height: 1.1rem; border-width: 2px; display: none; }
        .btn-primary-custom.loading .spinner-border { display: inline-block; }
        .btn-primary-custom.loading .btn-text { display: none; }
        .btn-primary-custom.loading .btn-loading { display: inline; }
        .btn-primary-custom .btn-loading { display: none; }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }
        .back-link:hover { color: var(--brand-blue); }

        .alert-custom {
            border-radius: 0.75rem;
            border: none;
            font-size: 0.84rem;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            margin-bottom: 1.25rem;
        }
        .alert-custom.alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 3px solid #ef4444;
        }
        .alert-custom.alert-danger i { color: #ef4444; font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        .alert-custom.alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 3px solid #22c55e;
        }
        .alert-custom.alert-success i { color: #22c55e; font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        [data-bs-theme="dark"] .alert-custom.alert-danger {
            background: rgba(239,68,68,0.08);
            color: #fca5a5;
        }
        [data-bs-theme="dark"] .alert-custom.alert-success {
            background: rgba(34,197,94,0.08);
            color: #86efac;
        }

        .theme-toggle {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 1060;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 0.65rem;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(8px);
        }
        .theme-toggle:hover { background: rgba(255,255,255,0.15); color: #fff; }
    </style>
</head>
<body>
    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">
        <i class="bi bi-moon-stars-fill"></i>
    </button>

    <div class="auth-card">
        <div class="card-icon blue">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h1 class="card-title">Lupa Password?</h1>
        <p class="card-subtitle">
            Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

        @if (session('status'))
            <div class="alert-custom alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-custom alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
            @csrf

            <div class="form-floating-label">
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email"
                       value="{{ old('email') }}"
                       required autofocus autocomplete="email">
                <label for="email">Alamat Email</label>
            </div>

            <button type="submit" class="btn-primary-custom" id="submitBtn">
                <span class="btn-text">
                    <i class="bi bi-send"></i> Kirim Tautan Reset
                </span>
                <span class="btn-loading">
                    <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                    Mengirim...
                </span>
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke halaman login
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        document.getElementById('forgotForm').addEventListener('submit', function () {
            var btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>
