<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Informasi Klinik')</title>
    <script>
        (function () {
            var theme = 'light';
            try {
                theme = localStorage.getItem('theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            } catch (e) {}
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #0d6efd;
            --brand-success: #198754;
            --brand-dark: #0b1b33;
            --app-bg: #f4f6fb;
            --surface: #ffffff;
            --surface-subtle: #f7f9fc;
            --border-color: #e6e9f0;
            --heading-color: #0b1b33;
            --text-muted: #6c757d;
            --shadow-color: 11, 27, 51;
        }
        [data-bs-theme="dark"] {
            --app-bg: #0c1626;
            --surface: #141f33;
            --surface-subtle: #0f1930;
            --border-color: rgba(255, 255, 255, 0.08);
            --heading-color: #e8edf4;
            --text-muted: #9fb0c7;
            --shadow-color: 0, 0, 0;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--app-bg);
            color: var(--heading-color);
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0b1b33 0%, #132a4d 100%);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1045;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.25s ease-in-out;
        }
        .sidebar.sidebar-open {
            transform: translateX(0);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.25);
        }
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(11, 27, 51, 0.5);
            backdrop-filter: blur(2px);
        }
        .sidebar-backdrop.show {
            display: block;
        }
        @media (min-width: 992px) {
            .sidebar {
                position: sticky;
                bottom: auto;
                height: 100vh;
                transform: none;
                box-shadow: none;
            }
            .sidebar-backdrop {
                display: none !important;
            }
            body.sidebar-collapsed .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                height: 100vh;
                transform: translateX(-100%);
                box-shadow: none;
            }
        }
        .sidebar .nav-link {
            color: #b8c6db;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: var(--brand-primary);
        }
        .sidebar .nav-link .bi {
            margin-right: 0.6rem;
        }
        .sidebar .menu-label {
            color: #6c8aab;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 1rem 0.35rem;
        }
        .sidebar .brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .sidebar .brand .bi {
            font-size: 1.6rem;
            color: #fff;
            background: var(--brand-primary);
            border-radius: 0.75rem;
            padding: 0.4rem;
        }
        .sidebar .brand span {
            color: #fff;
            font-weight: 600;
            font-size: 1.05rem;
            line-height: 1.2;
        }
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }
        @media (min-width: 768px) {
            .topbar {
                padding: 0.9rem 1.5rem;
            }
        }
        .stat-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.15s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-card .icon {
            width: 52px;
            height: 52px;
            border-radius: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .card-table {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(var(--shadow-color), 0.06);
        }
        .card-table thead {
            background: var(--surface-subtle);
        }
        .card-table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-muted);
            font-weight: 600;
        }
        .page-title {
            font-weight: 700;
            color: var(--heading-color);
        }
        .btn-brand {
            background: var(--brand-primary);
            border-color: var(--brand-primary);
            --bs-btn-hover-bg: #0b5ed7;
            --bs-btn-hover-border-color: #0a58ca;
            --bs-btn-active-bg: #0a58ca;
            --bs-btn-active-border-color: #0a53be;
            --bs-btn-disabled-bg: var(--brand-primary);
            --bs-btn-disabled-border-color: var(--brand-primary);
        }
        .badge-status {
            font-size: 0.72rem;
            padding: 0.4em 0.7em;
        }
        main {
            min-height: 100vh;
        }

        [data-bs-theme="dark"] .bg-white {
            background-color: var(--surface) !important;
        }
        [data-bs-theme="dark"] .input-group-text {
            background-color: var(--surface);
            border-color: var(--border-color);
            color: var(--text-muted);
        }
        .topbar .btn-light,
        .topbar .theme-btn {
            background: var(--surface-subtle);
            border: 1px solid var(--border-color);
            color: var(--heading-color);
            box-shadow: 0 1px 2px rgba(var(--shadow-color), 0.08);
        }
        .topbar .btn-light:hover,
        .topbar .theme-btn:hover {
            background: var(--border-color);
            color: var(--heading-color);
        }
        .topbar .btn-light:active,
        .topbar .theme-btn:active,
        .topbar .btn-light:focus-visible,
        .topbar .theme-btn:focus-visible {
            background: var(--surface-subtle);
            border-color: var(--brand-primary);
            color: var(--heading-color);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }
        [data-bs-theme="dark"] .topbar .btn-light,
        [data-bs-theme="dark"] .topbar .theme-btn {
            background: transparent;
            border-color: var(--border-color);
            color: var(--heading-color);
            box-shadow: none;
        }
        [data-bs-theme="dark"] .topbar .btn-light:hover,
        [data-bs-theme="dark"] .topbar .theme-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }
        [data-bs-theme="dark"] .topbar .btn-light:active,
        [data-bs-theme="dark"] .topbar .theme-btn:active,
        [data-bs-theme="dark"] .topbar .btn-light:focus-visible,
        [data-bs-theme="dark"] .topbar .theme-btn:focus-visible {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--brand-primary);
            color: #fff;
            box-shadow: none;
        }
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: var(--surface);
            border-color: var(--border-color);
        }
        [data-bs-theme="dark"] .dropdown-item {
            color: var(--heading-color);
        }
        [data-bs-theme="dark"] .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }
        [data-bs-theme="dark"] .table {
            --bs-table-bg: var(--surface);
            --bs-table-border-color: var(--border-color);
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04);
            color: var(--heading-color);
        }
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: var(--surface);
            border-color: var(--border-color);
        }
        [data-bs-theme="dark"] .card-header {
            background-color: var(--surface);
        }
        [data-bs-theme="dark"] .text-body-secondary {
            color: var(--text-muted) !important;
        }
        [data-bs-theme="dark"] .bg-light {
            background: rgba(255, 255, 255, 0.06) !important;
        }
        .theme-btn {
            transition: all 0.15s ease;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1 d-flex flex-column min-vh-100" style="min-width:0;">
            @include('layouts.header')

            <main class="flex-grow-1 p-3 p-md-4">
                <div class="container-fluid px-0">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>Ada beberapa kesalahan pada input Anda:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('sidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            var toggle = document.getElementById('sidebarToggle');
            if (!sidebar || !backdrop || !toggle) return;

            function isDesktop() { return window.innerWidth >= 992; }

            function setCollapsed(collapsed) {
                document.body.classList.toggle('sidebar-collapsed', collapsed);
                try { localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0'); } catch (e) {}
            }

            function openSidebar() {
                sidebar.classList.add('sidebar-open');
                backdrop.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('sidebar-open');
                backdrop.classList.remove('show');
                document.body.style.overflow = '';
            }

            try {
                if (isDesktop() && localStorage.getItem('sidebarCollapsed') === '1') {
                    document.body.classList.add('sidebar-collapsed');
                }
            } catch (e) {}

            toggle.addEventListener('click', function () {
                if (isDesktop()) {
                    setCollapsed(!document.body.classList.contains('sidebar-collapsed'));
                } else if (sidebar.classList.contains('sidebar-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            backdrop.addEventListener('click', closeSidebar);
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 992) closeSidebar();
            });
            sidebar.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', closeSidebar);
            });
        });
    </script>
    <script>
        (function () {
            var themeToggle = document.getElementById('themeToggle');
            if (!themeToggle) return;

            var current = document.documentElement.getAttribute('data-bs-theme') || 'light';
            var icon = themeToggle.querySelector('i');

            function syncIcon() {
                var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                icon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            }

            themeToggle.addEventListener('click', function () {
                current = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', current);
                try { localStorage.setItem('theme', current); } catch (e) {}
                syncIcon();
            });

            syncIcon();
        })();
    </script>
    @stack('scripts')
</body>
</html>
