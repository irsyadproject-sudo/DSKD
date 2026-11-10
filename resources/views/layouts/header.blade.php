<header class="topbar d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light" type="button" id="sidebarToggle" aria-label="Buka atau tutup menu samping">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 text-muted d-none d-sm-block">
            @yield('title', 'Dashboard')
        </h5>
    </div>

    <div class="d-flex align-items-center gap-2">
    <button class="btn btn-light theme-btn d-flex align-items-center gap-2" type="button"
            id="themeToggle" aria-label="Ganti tema gelap atau terang">
        <i class="bi bi-moon-stars-fill"></i>
    </button>

    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            @if ($avatar = (auth()->user()->avatar_url ?? null))
                <img src="{{ $avatar }}" class="rounded-circle" width="34" height="34" alt="Avatar">
            @else
                <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:34px;height:34px;">
                    <i class="bi bi-person-fill"></i>
                </span>
            @endif
            <span class="text-start d-none d-md-block">
                <span class="d-block fw-semibold" style="line-height:1.1;">{{ auth()->user()->name }}</span>
                <small class="text-muted" style="font-size:0.72rem;">{{ auth()->user()->roleLabel() ?? 'User' }}</small>
            </span>
            <i class="bi bi-chevron-down small text-muted"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="bi bi-person-gear me-2"></i> Profil Saya
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
</header>
