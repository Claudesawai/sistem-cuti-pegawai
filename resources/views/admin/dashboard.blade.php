@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

{{-- ══════════════════════════════════════
     WELCOME BANNER
══════════════════════════════════════ --}}
<div class="welcome-banner mb-4">
    <div class="welcome-banner-body">
        <div>
            <h4 class="welcome-title">Panel Admin — Sistem Cuti Pegawai 🛡️</h4>
            <p class="welcome-sub">Kelola data pegawai, pantau pengajuan cuti, dan lihat laporan lengkap di sini.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-banner">
                <i class="bi bi-person-plus me-1"></i>Tambah Pegawai
            </a>
            <a href="{{ route('admin.cuti.index') }}" class="btn btn-banner-outline">
                <i class="bi bi-file-earmark-text me-1"></i>Laporan Cuti
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     STAT CARDS
══════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-value">{{ $totalPegawai }}</div>
            <div class="stat-label">Total Pegawai</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon warning">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-value">{{ $totalAtasan }}</div>
            <div class="stat-label">Total Atasan</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card success">
            <div class="stat-icon success">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-value">{{ $totalCuti }}</div>
            <div class="stat-label">Total Pengajuan Cuti</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon danger">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value">{{ $cutiMenunggu }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     KONTEN UTAMA
══════════════════════════════════════ --}}
<div class="row g-4">

    {{-- ───── KIRI: Tabel Pengajuan Terbaru ───── --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pengajuan Cuti Terbaru</h5>
                <a href="{{ route('admin.cuti.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">

                @if($cutiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pegawai</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cutiTerbaru as $cuti)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="tbl-avatar">
                                                {{ strtoupper(substr($cuti->user->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-600">{{ $cuti->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size:.83rem;">
                                            {{ $cuti->jenis_cuti_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="tgl-badge">
                                            {{ $cuti->tanggal_mulai->format('d/m/Y') }} —
                                            {{ $cuti->tanggal_selesai->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $cuti->status_badge }}">
                                            {{ $cuti->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5>Belum ada pengajuan cuti</h5>
                        <p>Data pengajuan cuti dari pegawai akan muncul di sini</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ───── KANAN: Statistik + Quick Actions ───── --}}
    <div class="col-lg-4">

        {{-- Statistik Cuti --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Cuti</h5>
            </div>
            <div class="card-body">

                {{-- Disetujui --}}
                <div class="stat-row">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="stat-row-label">
                            <span class="stat-dot" style="background:#10b981;"></span>
                            Disetujui
                        </span>
                        <span class="stat-row-count text-success">{{ $cutiDisetujui }}</span>
                    </div>
                    <div class="progress-track">
                        @php $total = max($totalCuti, 1); @endphp
                        <div class="progress-fill"
                             style="width:{{ round(($cutiDisetujui/$total)*100) }}%;
                                    background: linear-gradient(90deg,#10b981,#34d399);">
                        </div>
                    </div>
                </div>

                {{-- Ditolak --}}
                <div class="stat-row">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="stat-row-label">
                            <span class="stat-dot" style="background:#ef4444;"></span>
                            Ditolak
                        </span>
                        <span class="stat-row-count text-danger">{{ $cutiDitolak }}</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width:{{ round(($cutiDitolak/$total)*100) }}%;
                                    background: linear-gradient(90deg,#ef4444,#f87171);">
                        </div>
                    </div>
                </div>

                {{-- Menunggu --}}
                <div class="stat-row" style="margin-bottom:0;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="stat-row-label">
                            <span class="stat-dot" style="background:#f59e0b;"></span>
                            Menunggu
                        </span>
                        <span class="stat-row-count text-warning">{{ $cutiMenunggu }}</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width:{{ round(($cutiMenunggu/$total)*100) }}%;
                                    background: linear-gradient(90deg,#f59e0b,#fbbf24);">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">

                    <div class="col-6">
                        <a href="{{ route('admin.users.create') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#eff6ff; color:#2563eb;">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="quick-label">Tambah Pegawai</div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('admin.cuti.index') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#f0fdf4; color:#10b981;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="quick-label">Laporan Cuti</div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('admin.users.index') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#fffbeb; color:#f59e0b;">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="quick-label">Kelola Pegawai</div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('profil') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#fdf4ff; color:#9333ea;">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="quick-label">Profil Saya</div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Welcome Banner ── */
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1e3a5f 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        box-shadow: 0 8px 24px rgba(0,0,0,.2);
        border: 1px solid rgba(255,255,255,.06);
    }

    .welcome-banner-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .welcome-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #f1f5f9;
        margin-bottom: .3rem;
    }

    .welcome-sub {
        font-size: .82rem;
        color: rgba(255,255,255,.5);
        margin: 0;
    }

    .btn-banner {
        background: rgba(255,255,255,.95);
        color: #1d4ed8;
        font-weight: 700;
        font-size: .8rem;
        border: none;
        padding: .55rem 1.1rem;
        border-radius: 9px;
        transition: all .2s;
    }

    .btn-banner:hover {
        background: #fff;
        color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,.2);
    }

    .btn-banner-outline {
        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.85);
        font-weight: 600;
        font-size: .8rem;
        border: 1px solid rgba(255,255,255,.15);
        padding: .55rem 1.1rem;
        border-radius: 9px;
        transition: all .2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-banner-outline:hover {
        background: rgba(255,255,255,.15);
        color: #fff;
    }

    /* ── Tabel Avatar ── */
    .tbl-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .75rem; color: white;
        flex-shrink: 0;
    }

    .tgl-badge {
        font-size: .78rem;
        color: #64748b;
        background: #f1f5f9;
        padding: .25rem .65rem;
        border-radius: 99px;
        white-space: nowrap;
    }

    /* ── Statistik Rows ── */
    .stat-row { margin-bottom: 1.1rem; }

    .stat-row-label {
        font-size: .82rem;
        color: var(--text-muted);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .stat-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .stat-row-count {
        font-size: .875rem;
        font-weight: 700;
    }

    /* ── Progress Bar ── */
    .progress-track {
        height: 7px;
        background: #e2e8f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 99px;
        transition: width .8s ease;
        min-width: 4px;
    }

    /* ── Quick Buttons ── */
    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
        padding: .9rem .5rem;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--surface-2);
        text-decoration: none;
        transition: all .2s;
    }

    .quick-btn:hover {
        border-color: #2563eb;
        background: #eff6ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37,99,235,.12);
    }

    .quick-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
    }

    .quick-label {
        font-size: .72rem;
        font-weight: 600;
        color: var(--text);
        text-align: center;
    }

    /* ── Utility ── */
    .fw-600 { font-weight: 600; }
</style>
@endsection