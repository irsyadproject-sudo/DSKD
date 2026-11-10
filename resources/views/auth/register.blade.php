<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Pasien - Klinik Sehat</title>
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
            --bg-gradient-2: #12304f;
            --bg-gradient-3: #0d1f33;
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
            --input-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background:
                radial-gradient(circle at 15% 20%, rgba(59,130,246,0.25) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(20,184,166,0.2) 0%, transparent 40%),
                linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 55%, var(--bg-gradient-3) 100%);
            color: var(--text-primary);
            position: relative;
        }
        .theme-toggle {
            position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1060;
            width: 40px; height: 40px; border: 1px solid rgba(255,255,255,0.14);
            border-radius: 0.65rem; background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.75); font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s; backdrop-filter: blur(8px);
        }
        .theme-toggle:hover { background: rgba(255,255,255,0.18); color: #fff; }

        .register-card {
            width: 100%;
            max-width: 760px;
            background: var(--surface);
            border-radius: 1.4rem;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
        }
        .register-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--brand-blue), var(--brand-teal), #8b5cf6, var(--brand-blue));
            background-size: 300% 100%;
            animation: accentSlide 8s linear infinite;
        }
        @keyframes accentSlide { 0% { background-position: 0% 0; } 100% { background-position: 300% 0; } }

        .register-body { padding: 2.25rem 2.5rem; }
        @media (max-width: 520px) { .register-body { padding: 1.5rem 1.25rem; } }

        .register-header { text-align: center; margin-bottom: 1.75rem; }
        .register-header .reg-icon {
            width: 62px; height: 62px; border-radius: 1.1rem;
            background: linear-gradient(135deg, var(--brand-blue), var(--brand-teal));
            color: #fff; display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.7rem; margin-bottom: 1rem;
            box-shadow: 0 8px 26px rgba(59,130,246,0.35);
        }
        .register-header h1 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.35rem; }
        .register-header p { font-size: 0.88rem; color: var(--text-secondary); margin: 0; }

        .form-section-title {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.75rem; font-weight: 600; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.08em; margin: 1.4rem 0 1.1rem;
        }
        .form-section-title:first-of-type { margin-top: 0; }
        .form-section-title::after { content: ''; flex: 1; height: 1px; background: var(--surface-border); }

        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 500; color: var(--text-secondary); margin-bottom: 0.4rem; }
        .form-group label .req { color: #ef4444; }
        .form-control {
            height: 46px; border: 1.5px solid var(--surface-border); border-radius: 0.7rem;
            font-size: 0.88rem; color: var(--text-primary); background: var(--surface);
            box-shadow: var(--input-shadow); transition: all 0.2s ease;
        }
        [data-bs-theme="dark"] .form-control { background: var(--surface); border-color: var(--surface-border); }
        .form-control:focus {
            border-color: var(--brand-blue); box-shadow: 0 0 0 3px var(--accent-glow), var(--input-shadow);
        }
        .form-control.is-invalid { border-color: #ef4444; }
        textarea.form-control { height: auto; resize: vertical; }
        .error-text { font-size: 0.74rem; color: #ef4444; margin-top: 0.3rem; display: block; }

        .pass-wrap { position: relative; }
        .pass-wrap .form-control { padding-right: 2.7rem; }
        .pass-wrap .toggle-pass {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-muted); cursor: pointer;
            padding: 0.25rem; font-size: 1rem; transition: color 0.15s;
        }
        .pass-wrap .toggle-pass:hover { color: var(--text-secondary); }

        .btn-register {
            width: 100%; height: 50px; border: none; border-radius: 0.8rem;
            font-size: 0.92rem; font-weight: 600; color: #fff;
            background: linear-gradient(135deg, var(--brand-blue), #4f7cf7);
            cursor: pointer; transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(59,130,246,0.3);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-register:hover {
            transform: translateY(-1px); box-shadow: 0 6px 26px rgba(59,130,246,0.42);
            background: linear-gradient(135deg, var(--brand-blue-hover), #4f7cf7);
        }
        .btn-register:disabled { opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-register .spinner-border { width: 1.1rem; height: 1.1rem; border-width: 2px; display: none; }
        .btn-register.loading .spinner-border { display: inline-block; }
        .btn-register.loading .btn-text { display: none; }
        .btn-register.loading .btn-loading { display: inline; }
        .btn-register .btn-loading { display: none; }

        .alert-custom {
            border-radius: 0.75rem; border: none; font-size: 0.84rem;
            padding: 0.85rem 1rem; display: flex; align-items: flex-start; gap: 0.65rem; margin-bottom: 1rem;
        }
        .alert-custom.alert-danger { background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444; }
        .alert-custom.alert-danger i { color: #ef4444; font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        [data-bs-theme="dark"] .alert-custom.alert-danger { background: rgba(239,68,68,0.08); color: #fca5a5; }

        .login-link {
            text-align: center; margin-top: 1.5rem; font-size: 0.86rem; color: var(--text-secondary);
        }
        .login-link a { color: var(--brand-blue); font-weight: 600; text-decoration: none; transition: color 0.15s; }
        .login-link a:hover { color: var(--brand-blue-hover); }

        .security-note {
            display: flex; align-items: center; justify-content: center; gap: 0.45rem;
            margin-top: 1.25rem; font-size: 0.74rem; color: var(--text-muted);
        }
        .security-note i { color: var(--brand-teal); }
    </style>
</head>
<body>
    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">
        <i class="bi bi-moon-stars-fill"></i>
    </button>

    <div class="register-card">
        <div class="register-body">
            <div class="register-header">
                <div class="reg-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h1>Daftar Akun Pasien</h1>
                <p>Buat akun Anda di <strong>Klinik Sehat</strong> untuk mengakses layanan pendaftaran, status antrean, dan riwayat pemeriksaan.</p>
            </div>

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

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-section-title">Data Akun</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama sesuai KTP" required autofocus>
                            @error('nama') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" required>
                            @error('email') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password <span class="req">*</span></label>
                            <div class="pass-wrap">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Konfirmasi Password <span class="req">*</span></label>
                            <div class="pass-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="togglePassword('password_confirmation', this)" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Data Pasien</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NIK <span class="req">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" placeholder="16 digit NIK" maxlength="16" required inputmode="numeric">
                            @error('nik') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Kelamin <span class="req">*</span></label>
                            <select name="jenis_kelamin" class="form-control form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Lahir <span class="req">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                            @error('tanggal_lahir') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror" placeholder="08xxxxxxxxxx" maxlength="20">
                            @error('no_hp') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <select name="golongan_darah" class="form-control form-select @error('golongan_darah') is-invalid @enderror">
                                <option value="" {{ old('golongan_darah') ? '' : 'selected' }}>-</option>
                                @foreach (['A', 'B', 'AB', 'O'] as $gd)
                                    <option value="{{ $gd }}" {{ old('golongan_darah') === $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                @endforeach
                            </select>
                            @error('golongan_darah') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" maxlength="500" placeholder="Alamat lengkap tempat tinggal">{{ old('alamat') }}</textarea>
                            @error('alamat') <span class="error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-register mt-2" id="registerBtn">
                    <span class="btn-text">
                        <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
                    </span>
                    <span class="btn-loading">
                        <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                        Memproses...
                    </span>
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

            <div class="security-note">
                <i class="bi bi-shield-check"></i>
                <span>Data pribadi Anda dienkripsi & dijaga kerahasiaannya</span>
            </div>
        </div>
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

        function togglePassword(id, btn) {
            var field = document.getElementById(id);
            var icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function () {
            var btn = document.getElementById('registerBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>