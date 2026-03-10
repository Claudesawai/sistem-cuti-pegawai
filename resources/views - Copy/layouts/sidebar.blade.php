<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-calendar-check"></i>
            <span>Sistem Cuti Pegawai</span>
        </a>
    </div>

    <div class="sidebar-menu">
        @php
            $role = auth()->user()->role;
        @endphp

        @if($role === 'admin')
            {{-- Admin Menu --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Data Pegawai</span>
            </a>
            
            <a href="{{ route('admin.cuti.index') }}" class="nav-link {{ request()->routeIs('admin.cuti.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i>
                <span>Data Cuti</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            {{-- TAMBAHAN: Menu Profil --}}
            <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
        @endif

        @if($role === 'atasan')
            {{-- Atasan Menu --}}
            <a href="{{ route('atasan.dashboard') }}" class="nav-link {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <a href="{{ route('atasan.pengajuan.index') }}" class="nav-link {{ request()->routeIs('atasan.pengajuan.*') ? 'active' : '' }}">
                <i class="bi bi-inbox"></i>
                <span>Pengajuan Cuti</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            {{-- TAMBAHAN: Menu Profil --}}
            <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
        @endif

        @if($role === 'pegawai')
            {{-- Pegawai Menu --}}
            <a href="{{ route('pegawai.dashboard') }}" class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <a href="{{ route('pegawai.cuti.create') }}" class="nav-link {{ request()->routeIs('pegawai.cuti.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>Ajukan Cuti</span>
            </a>
            
            <a href="{{ route('pegawai.cuti.riwayat') }}" class="nav-link {{ request()->routeIs('pegawai.cuti.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Cuti</span>
            </a>
            
            <a href="{{ route('pegawai.cuti.sisa') }}" class="nav-link {{ request()->routeIs('pegawai.cuti.sisa') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Sisa Cuti</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            {{-- TAMBAHAN: Menu Profil --}}
            <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                {{-- TAMBAHAN: Tampilkan NIP --}}
                <div class="user-nip" style="font-size: 12px; color: #aaa;">
                    NIP: {{ auth()->user()->nip ?? '-' }}
                </div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-box-arrow-left me-2"></i>Logout
            </button>
        </form>
    </div>
</div>