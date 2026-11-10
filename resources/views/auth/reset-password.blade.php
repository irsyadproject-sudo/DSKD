<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Klinik Sehat</title>
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
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 50%, var(--bg-gradient-3) 100%);
            padding: 2rem 1rem;
            color: var(--text-primary);
            position: relative;
            overflow: hidden;
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
            background: var(--brand-teal-soft);
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
            z-index: 1;
        }
        .form-floating-label .form-control {
            height: 48px;
            border: 1.5px solid var(--surface-border);
            border-radius: 0.75rem;
            font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--surface);
            padding: 0 2.8rem 0 0.9rem;
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
        .form-floating-label .toggle-pass {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            font-size: 1.05rem;
            transition: color 0.15s;
            z-index: 5;
        }
        .form-floating-label .toggle-pass:hover { color: var(--text-secondary); }

        .password-strength {
            margin-bottom: 1.25rem;
        }
        .password-strength .strength-bar {
            display: flex;
            gap: 4px;
            height: 5px;
            margin-bottom: 0.5rem;
        }
        .password-strength .strength-bar span {
            flex: 1;
            border-radius: 999px;
            background: var(--surface-border);
            transition: background 0.3s;
        }
        .strength-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .strength-hint.weak { color: #ef4444; }
        .strength-hint.medium { color: #f59e0b; }
        .strength-hint.strong { color: #22c55e; }

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
        <div class="card-icon">
            <i class="bi bi-key"></i>
        </div>

        <h1 class="card-title">Reset Password</h1>
        <p class="card-subtitle">
            Buat password baru untuk akun Anda. Pastikan minimal 8 karakter.
        </p>

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

        <form method="POST" action="{{ route('password.store') }}" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-floating-label">
                <input type="email" id="email_display"
                       class="form-control"
                       value="{{ $email }}"
                       disabled autocomplete="off">
                <label for="email_display">Alamat Email</label>
            </div>

            <div class="form-floating-label">
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password baru"
                       required minlength="8" autocomplete="new-password">
                <label for="password">Password Baru</label>
                <button type="button" class="toggle-pass" onclick="togglePass('password', 'ic1')" aria-label="Tampilkan password">
                    <i class="bi bi-eye" id="ic1"></i>
                </button>
                <div class="password-strength">
                    <div class="strength-bar">
                        <span id="bar1"></span>
                        <span id="bar2"></span>
                        <span id="bar3"></span>
                        <span id="bar4"></span>
                    </div>
                    <span class="strength-hint" id="strengthHint">Gunakan kombinasi huruf, angka & simbol.</span>
                </div>
            </div>

            <div class="form-floating-label">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password"
                       required minlength="8" autocomplete="new-password">
                <label for="password_confirmation">Konfirmasi Password</label>
                <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', 'ic2')" aria-label="Tampilkan password">
                    <i class="bi bi-eye" id="ic2"></i>
                </button>
            </div>

            <button type="submit" class="btn-primary-custom" id="submitBtn">
                <span class="btn-text">
                    <i class="bi bi-check-circle"></i> Simpan Password Baru
                </span>
                <span class="btn-loading">
                    <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                    Menyimpan...
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

        function togglePass(fieldId, iconId) {
            var input = document.getElementById(fieldId);
            var icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function () {
            var value = this.value;
            var score = 0;
            if (value.length >= 8) score++;
            if (value.length >= 12) score++;
            if (/[A-Z]/.test(value) && /[a-z]/.test(value)) score++;
            if (/[0-9]/.test(value) && /[^A-Za-z0-9]/.test(value)) score++;

            var bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
            var colors = ['#ef4444', '#f59e0b', '#84cc16', '#22c55e'];
            var hint = document.getElementById('strengthHint');

            for (var i = 0; i < 4; i++) {
                bars[i].style.background = i < score ? colors[score - 1] : '';
            }

            if (value.length === 0) {
                hint.className = 'strength-hint';
                hint.textContent = 'Gunakan kombinasi huruf, angka & simbol.';
            } else if (score === 1) {
                hint.className = 'strength-hint weak';
                hint.textContent = 'Lemah - tambahkan lebih banyak karakter.';
            } else if (score === 2) {
                hint.className = 'strength-hint medium';
                hint.textContent = 'Sedang - masih bisa diperkuat.';
            } else if (score === 3) {
                hint.className = 'strength-hint medium';
                hint.textContent = 'Baik - kombinasi yang cukup kuat.';
            } else {
                hint.className = 'strength-hint strong';
                hint.textContent = 'Kuat - password sangat aman.';
            }
        });

        // Validate password match before submit
        document.getElementById('resetForm').addEventListener('submit', function (e) {
            var p1 = document.getElementById('password').value;
            var p2 = document.getElementById('password_confirmation').value;
            if (p1 !== p2) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok. Silakan periksa kembali.');
                document.getElementById('password_confirmation').focus();
                return;
            }
            var btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>