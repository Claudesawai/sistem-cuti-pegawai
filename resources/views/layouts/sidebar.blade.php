<div class="sidebar">

    {{-- ══════════ HEADER / LOGO ══════════ --}}
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="sidebar-brand-text">
                <div class="title">Sistem Cuti</div>
                <div class="subtitle">Pemkab Bima</div>
            </div>
        </a>
    </div>

    {{-- ══════════ MENU ══════════ --}}
    <div class="sidebar-menu">
        @php
            $role = auth()->user()->role;
        @endphp

        {{-- ───── MENU ADMIN ───── --}}
        @if($role === 'admin')

            <div class="sidebar-section-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Data Pegawai</span>
            </a>

            <a href="{{ route('admin.cuti.index') }}"
               class="nav-link {{ request()->routeIs('admin.cuti.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i>
                <span>Data Cuti</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section-label">Akun</div>

            <a href="{{ route('profil') }}"
               class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>

        @endif

        {{-- ───── MENU ATASAN ───── --}}
        @if($role === 'atasan')

            <div class="sidebar-section-label">Menu Utama</div>

            <a href="{{ route('atasan.dashboard') }}"
               class="nav-link {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('atasan.pengajuan.index') }}"
               class="nav-link {{ request()->routeIs('atasan.pengajuan.*') ? 'active' : '' }}">
                <i class="bi bi-inbox"></i>
                <span>Pengajuan Cuti</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section-label">Akun</div>

            <a href="{{ route('profil') }}"
               class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>

        @endif

        {{-- ───── MENU PEGAWAI ───── --}}
        @if($role === 'pegawai')

            <div class="sidebar-section-label">Menu Utama</div>

            <a href="{{ route('pegawai.dashboard') }}"
               class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section-label">Cuti</div>

            <a href="{{ route('pegawai.cuti.create') }}"
               class="nav-link {{ request()->routeIs('pegawai.cuti.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>Ajukan Cuti</span>
            </a>

            <a href="{{ route('pegawai.cuti.riwayat') }}"
               class="nav-link {{ request()->routeIs('pegawai.cuti.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Cuti</span>
            </a>

            <a href="{{ route('pegawai.cuti.sisa') }}"
               class="nav-link {{ request()->routeIs('pegawai.cuti.sisa') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Sisa Cuti</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section-label">Akun</div>

            <a href="{{ route('profil') }}"
               class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>

        @endif

    </div>

    {{-- ══════════ FOOTER / USER INFO ══════════ --}}
    <div class="sidebar-footer">

        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div style="font-size: .68rem; color: #64748b; margin: 1px 0;">
                    NIP: {{ auth()->user()->nip ?? '-' }}
                </div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i>
                Logout
            </button>
        </form>

    </div>

</div>