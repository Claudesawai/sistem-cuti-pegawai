@extends('layouts.app')

@section('title', 'Dashboard Pegawai')
@section('page-title', 'Dashboard Pegawai')

@section('content')

{{-- ══════════════════════════════════════
     WELCOME BANNER
══════════════════════════════════════ --}}
<div class="welcome-banner mb-4">
    <div class="welcome-banner-body">
        <div>
            <h4 class="welcome-title">Halo, {{ auth()->user()->name }}! 👋</h4>
            <p class="welcome-sub">Pantau dan kelola pengajuan cuti Anda dengan mudah di sini.</p>
        </div>
        <a href="{{ route('pegawai.cuti.create') }}" class="btn btn-light btn-ajukan">
            <i class="bi bi-plus-circle me-2"></i>Ajukan Cuti
        </a>
    </div>
</div>

{{-- ══════════════════════════════════════
     STAT CARDS
══════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $sisaCuti }}</div>
            <div class="stat-label">Sisa Cuti Tahunan</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon warning">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value">{{ $cutiMenunggu }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card success">
            <div class="stat-icon success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value">{{ $cutiDisetujui }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon danger">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-value">{{ $cutiDitolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     KONTEN UTAMA
══════════════════════════════════════ --}}
<div class="row g-4">

    {{-- ───── KIRI: Riwayat Terbaru ───── --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Riwayat Pengajuan Terbaru
                </h5>
                <a href="{{ route('pegawai.cuti.riwayat') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">

                @if($riwayatTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatTerbaru as $cuti)
                                <tr>
                                    <td>
                                        <span class="fw-600">{{ $cuti->jenis_cuti_label }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size:.82rem;">
                                            {{ $cuti->tanggal_mulai->format('d/m/Y') }} —
                                            {{ $cuti->tanggal_selesai->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="hari-badge">{{ $cuti->jumlah_hari }} hari</span>
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
                        <h5>Belum ada riwayat pengajuan</h5>
                        <p>Ajukan cuti pertama Anda sekarang dan lacak statusnya di sini</p>
                        <a href="{{ route('pegawai.cuti.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="bi bi-plus-circle me-1"></i>Ajukan Cuti Sekarang
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ───── KANAN: Info + Quick Actions ───── --}}
    <div class="col-lg-4">

        {{-- Info Cuti --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Cuti</h5>
            </div>
            <div class="card-body">

                <div class="info-row">
                    <span class="info-label">Jatah Cuti Tahunan</span>
                    <span class="info-value">12 hari</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Cuti Terpakai</span>
                    <span class="info-value">{{ 12 - $sisaCuti }} hari</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Sisa Cuti</span>
                    <span class="info-value text-primary fw-bold">{{ $sisaCuti }} hari</span>
                </div>

                <div class="info-row" style="border:none; padding-bottom:0;">
                    <span class="info-label">Total Pengajuan</span>
                    <span class="info-value">{{ $totalPengajuan }} pengajuan</span>
                </div>

                {{-- Progress Bar --}}
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted fw-500">Kuota Cuti Terpakai</small>
                        <small class="text-muted fw-500">{{ round(((12 - $sisaCuti) / 12) * 100) }}%</small>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width: {{ round(((12 - $sisaCuti) / 12) * 100) }}%">
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
                        <a href="{{ route('pegawai.cuti.create') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#eff6ff; color:#2563eb;">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="quick-label">Ajukan Cuti</div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('pegawai.cuti.riwayat') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#f0fdf4; color:#10b981;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="quick-label">Riwayat</div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('pegawai.cuti.sisa') }}" class="quick-btn">
                            <div class="quick-icon" style="background:#fffbeb; color:#f59e0b;">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="quick-label">Sisa Cuti</div>
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
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        box-shadow: 0 8px 24px rgba(37,99,235,.3);
    }

    .welcome-banner-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .welcome-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: .3rem;
    }

    .welcome-sub {
        font-size: .83rem;
        color: rgba(255,255,255,.75);
        margin: 0;
    }

    .btn-ajukan {
        background: rgba(255,255,255,.95);
        color: #1d4ed8;
        font-weight: 700;
        font-size: .83rem;
        border: none;
        padding: .6rem 1.25rem;
        border-radius: 10px;
        white-space: nowrap;
        transition: all .2s;
    }

    .btn-ajukan:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,.15);
        color: #1d4ed8;
    }

    /* ── Info Rows ── */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .65rem 0;
        border-bottom: 1px solid var(--border);
    }

    .info-label {
        font-size: .82rem;
        color: var(--text-muted);
    }

    .info-value {
        font-size: .875rem;
        font-weight: 600;
        color: var(--text);
    }

    /* ── Progress Bar ── */
    .progress-track {
        height: 8px;
        background: #e2e8f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        transition: width .8s ease;
        min-width: 4px;
    }

    /* ── Hari Badge ── */
    .hari-badge {
        background: #f1f5f9;
        color: #475569;
        padding: .25rem .65rem;
        border-radius: 99px;
        font-size: .75rem;
        font-weight: 600;
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
        cursor: pointer;
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
        font-size: .75rem;
        font-weight: 600;
        color: var(--text);
        text-align: center;
    }

    /* ── Utility ── */
    .fw-500 { font-weight: 500; }
    .fw-600 { font-weight: 600; }
</style>
@endsection