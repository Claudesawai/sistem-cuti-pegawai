@extends('layouts.app')

@section('title', 'Detail Cuti')
@section('page-title', 'Detail Pengajuan Cuti')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- ── Breadcrumb ── --}}
        <nav class="mb-3" style="font-size:.82rem;">
            <a href="{{ route('pegawai.dashboard') }}"
               style="color:var(--text-muted); text-decoration:none;">
                <i class="bi bi-house me-1"></i>Dashboard
            </a>
            <span class="mx-2" style="color:var(--text-light);">/</span>
            <a href="{{ route('pegawai.cuti.riwayat') }}"
               style="color:var(--text-muted); text-decoration:none;">
                Riwayat Cuti
            </a>
            <span class="mx-2" style="color:var(--text-light);">/</span>
            <span style="color:var(--text); font-weight:600;">Detail Pengajuan</span>
        </nav>

        {{-- ── Status Banner ── --}}
        <div class="status-banner status-{{ $cuti->status_badge }} mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="status-banner-icon">
                    @if($cuti->status == 'disetujui')
                        <i class="bi bi-check-circle-fill"></i>
                    @elseif($cuti->status == 'ditolak')
                        <i class="bi bi-x-circle-fill"></i>
                    @else
                        <i class="bi bi-hourglass-split"></i>
                    @endif
                </div>
                <div>
                    <div class="status-banner-label">Status Pengajuan</div>
                    <div class="status-banner-value">{{ $cuti->status_label }}</div>
                </div>
                <div class="ms-auto">
                    <span class="badge badge-{{ $cuti->status_badge }} fs-6">
                        {{ $cuti->status_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Detail Card ── --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Pengajuan Cuti</h5>
            </div>
            <div class="card-body">

                {{-- Info 2 Kolom --}}
                <div class="row g-4 mb-4">

                    {{-- Informasi Cuti --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="bi bi-calendar-event me-2"></i>Informasi Cuti
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Jenis Cuti</span>
                                <span class="detail-value fw-bold">
                                    {{ $cuti->jenis_cuti_label }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Tanggal Mulai</span>
                                <span class="detail-value">
                                    {{ $cuti->tanggal_mulai->format('d F Y') }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Tanggal Selesai</span>
                                <span class="detail-value">
                                    {{ $cuti->tanggal_selesai->format('d F Y') }}
                                </span>
                            </div>
                            <div class="detail-row" style="border:none;">
                                <span class="detail-label">Jumlah Hari</span>
                                <span class="detail-value">
                                    <span class="hari-badge">
                                        {{ $cuti->jumlah_hari }} hari
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Pengajuan --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="bi bi-info-circle me-2"></i>Informasi Pengajuan
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Tanggal Pengajuan</span>
                                <span class="detail-value">
                                    {{ $cuti->created_at->format('d F Y H:i') }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="badge badge-{{ $cuti->status_badge }}">
                                        {{ $cuti->status_label }}
                                    </span>
                                </span>
                            </div>
                            @if($cuti->approver)
                            <div class="detail-row">
                                <span class="detail-label">
                                    {{ $cuti->status == 'disetujui' ? 'Disetujui' : 'Ditolak' }} Oleh
                                </span>
                                <span class="detail-value fw-bold">
                                    {{ $cuti->approver->name }}
                                </span>
                            </div>
                            <div class="detail-row" style="border:none;">
                                <span class="detail-label">Tanggal Keputusan</span>
                                <span class="detail-value">
                                    {{ $cuti->updated_at->format('d F Y H:i') }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Alasan Cuti --}}
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-chat-left-text me-2"></i>Alasan Cuti
                    </div>
                    <div class="alasan-box">
                        {{ $cuti->alasan }}
                    </div>
                </div>

                {{-- File Pendukung --}}
                @if($cuti->file_pendukung)
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-paperclip me-2"></i>File Pendukung
                    </div>
                    <a href="{{ asset('storage/' . $cuti->file_pendukung) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-file-earmark-arrow-down me-2"></i>Lihat / Unduh File
                    </a>
                </div>
                @endif

                {{-- Catatan Atasan --}}
                @if($cuti->catatan_atasan)
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-person-check me-2"></i>Catatan Atasan
                    </div>
                    <div class="catatan-box">
                        <i class="bi bi-quote me-1" style="color:var(--text-light);"></i>
                        {{ $cuti->catatan_atasan }}
                    </div>
                </div>
                @endif

                {{-- Tombol Kembali --}}
                <div class="d-flex justify-content-end pt-2 border-top">
                    <a href="{{ route('pegawai.cuti.riwayat') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Status Banner ── */
    .status-banner {
        border-radius: 14px;
        padding: 1.1rem 1.5rem;
    }

    .status-banner.status-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1.5px solid #6ee7b7;
    }

    .status-banner.status-danger {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border: 1.5px solid #fca5a5;
    }

    .status-banner.status-warning {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1.5px solid #fcd34d;
    }

    .status-banner-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        background: rgba(255,255,255,.7);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .status-banner.status-success .status-banner-icon { color: #10b981; }
    .status-banner.status-danger  .status-banner-icon { color: #ef4444; }
    .status-banner.status-warning .status-banner-icon { color: #f59e0b; }

    .status-banner-label {
        font-size: .72rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .status-banner-value {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text);
    }

    /* ── Detail Section ── */
    .detail-section {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 1.1rem;
        height: 100%;
    }

    .detail-section-title {
        font-size: .82rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: .75rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid var(--border);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .5rem 0;
        border-bottom: 1px solid var(--border);
        gap: .5rem;
    }

    .detail-label {
        font-size: .8rem;
        color: var(--text-muted);
        flex-shrink: 0;
    }

    .detail-value {
        font-size: .85rem;
        color: var(--text);
        text-align: right;
    }

    /* ── Alasan & Catatan Box ── */
    .alasan-box {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-left: 4px solid var(--primary);
        border-radius: var(--radius-xs);
        padding: 1rem 1.25rem;
        font-size: .875rem;
        color: var(--text);
        line-height: 1.6;
    }

    .catatan-box {
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-left: 4px solid #f59e0b;
        border-radius: var(--radius-xs);
        padding: 1rem 1.25rem;
        font-size: .875rem;
        color: #92400e;
        line-height: 1.6;
    }

    /* ── Hari Badge ── */
    .hari-badge {
        background: #eff6ff;
        color: #1d4ed8;
        padding: .25rem .75rem;
        border-radius: 99px;
        font-size: .78rem;
        font-weight: 700;
    }

    .fw-bold { font-weight: 700 !important; }
</style>
@endsection