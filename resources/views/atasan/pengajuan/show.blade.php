@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Cuti')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">

        {{-- ── Breadcrumb ── --}}
        <nav class="mb-3" style="font-size:.82rem;">
            <a href="{{ route('atasan.pengajuan.index') }}"
               style="color:var(--text-muted); text-decoration:none;">
                <i class="bi bi-house me-1"></i>Pengajuan Cuti
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
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Pengajuan Cuti</h5>
            </div>
            <div class="card-body">

                <div class="row g-4 mb-4">

                    {{-- ── Informasi Pegawai ── --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="bi bi-person me-2"></i>Informasi Pegawai
                            </div>

                            {{-- Nama --}}
                            <div class="detail-row">
                                <span class="detail-label">Nama</span>
                                <span class="detail-value fw-bold">
                                    {{ $cuti->user->name }}
                                </span>
                            </div>

                            {{-- ✅ NIP DITAMBAHKAN DI SINI --}}
                            <div class="detail-row">
                                <span class="detail-label">NIP</span>
                                <span class="detail-value">
                                    @if($cuti->user->nip)
                                        <span class="nip-badge">{{ $cuti->user->nip }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Belum diisi</span>
                                    @endif
                                </span>
                            </div>

                            {{-- Email --}}
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value">{{ $cuti->user->email }}</span>
                            </div>

                            {{-- Jabatan --}}
                            <div class="detail-row">
                                <span class="detail-label">Jabatan</span>
                                <span class="detail-value">
                                    {{ $cuti->user->jabatan ?? '-' }}
                                </span>
                            </div>

                            {{-- Sisa Cuti --}}
                            <div class="detail-row" style="border:none;">
                                <span class="detail-label">Sisa Cuti</span>
                                <span class="detail-value">
                                    <span class="sisa-pill
                                        {{ $cuti->user->sisa_cuti > 5 ? 'sisa-ok' : ($cuti->user->sisa_cuti > 0 ? 'sisa-warn' : 'sisa-empty') }}">
                                        {{ $cuti->user->sisa_cuti }} hari
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ── Informasi Cuti ── --}}
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

                </div>

                {{-- Alasan Cuti --}}
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-chat-left-text me-2"></i>Alasan Cuti
                    </div>
                    <div class="alasan-box">{{ $cuti->alasan }}</div>
                </div>

                {{-- File Pendukung --}}
                @if($cuti->file_pendukung)
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-paperclip me-2"></i>File Pendukung
                    </div>
                    <a href="{{ asset('storage/' . $cuti->file_pendukung) }}"
                       target="_blank" class="btn btn-outline-primary btn-sm">
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

                {{-- Info Persetujuan --}}
                @if($cuti->approver)
                <div class="mb-4">
                    <div class="detail-section-title mb-2">
                        <i class="bi bi-shield-check me-2"></i>Informasi Persetujuan
                    </div>
                    <div class="detail-section">
                        <div class="detail-row">
                            <span class="detail-label">
                                {{ $cuti->status == 'disetujui' ? 'Disetujui' : 'Ditolak' }} Oleh
                            </span>
                            <span class="detail-value fw-bold">{{ $cuti->approver->name }}</span>
                        </div>
                        <div class="detail-row" style="border:none;">
                            <span class="detail-label">Tanggal Keputusan</span>
                            <span class="detail-value">
                                {{ $cuti->updated_at->format('d F Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Tombol Aksi --}}
                @if($cuti->status === 'menunggu')
                    <hr class="my-4">
                    <div class="d-flex gap-2 justify-content-end flex-wrap">
                        <button type="button" class="btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="bi bi-check-circle me-2"></i>Setujui
                        </button>
                        <button type="button" class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>Tolak
                        </button>
                        <a href="{{ route('atasan.pengajuan.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                @else
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('atasan.pengajuan.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

{{-- ══════════ MODAL SETUJUI ══════════ --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px; border:none;">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    Konfirmasi Persetujuan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('atasan.pengajuan.approve', $cuti) }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Info singkat pegawai --}}
                    <div class="approve-info-box mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="approve-avatar">
                                {{ strtoupper(substr($cuti->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; font-size:.9rem;">
                                    {{ $cuti->user->name }}
                                </div>
                                <div style="font-size:.78rem; color:var(--text-muted);">
                                    NIP: {{ $cuti->user->nip ?? 'Belum diisi' }}
                                    &nbsp;·&nbsp;
                                    {{ $cuti->jenis_cuti_label }}
                                    &nbsp;·&nbsp;
                                    {{ $cuti->jumlah_hari }} hari
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Peringatan sisa cuti --}}
                    @if($cuti->jenis_cuti === 'cuti_tahunan' && $cuti->user->sisa_cuti < $cuti->jumlah_hari)
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Perhatian!</strong> Sisa cuti pegawai tidak mencukupi.
                            Sisa: <strong>{{ $cuti->user->sisa_cuti }} hari</strong>,
                            Pengajuan: <strong>{{ $cuti->jumlah_hari }} hari</strong>.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="catatan_approve" class="form-label">
                            Catatan
                            <span class="badge-opsional">Opsional</span>
                        </label>
                        <textarea class="form-control" id="catatan_approve"
                                  name="catatan" rows="3"
                                  placeholder="Tambahkan catatan persetujuan..."></textarea>
                    </div>

                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Ya, Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ MODAL TOLAK ══════════ --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px; border:none;">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-x-circle text-danger me-2"></i>
                    Konfirmasi Penolakan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('atasan.pengajuan.reject', $cuti) }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Info singkat pegawai --}}
                    <div class="reject-info-box mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="approve-avatar" style="background:linear-gradient(135deg,#ef4444,#f87171);">
                                {{ strtoupper(substr($cuti->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; font-size:.9rem;">
                                    {{ $cuti->user->name }}
                                </div>
                                <div style="font-size:.78rem; color:var(--text-muted);">
                                    NIP: {{ $cuti->user->nip ?? 'Belum diisi' }}
                                    &nbsp;·&nbsp;
                                    {{ $cuti->jenis_cuti_label }}
                                    &nbsp;·&nbsp;
                                    {{ $cuti->jumlah_hari }} hari
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_reject" class="form-label">
                            Alasan Penolakan
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror"
                                  id="catatan_reject" name="catatan" rows="3"
                                  placeholder="Jelaskan alasan penolakan..." required></textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i>Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Status Banner ── */
    .status-banner { border-radius:14px; padding:1.1rem 1.5rem; }
    .status-banner.status-success { background:linear-gradient(135deg,#ecfdf5,#d1fae5); border:1.5px solid #6ee7b7; }
    .status-banner.status-danger  { background:linear-gradient(135deg,#fef2f2,#fee2e2); border:1.5px solid #fca5a5; }
    .status-banner.status-warning { background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1.5px solid #fcd34d; }

    .status-banner-icon {
        width:46px; height:46px; border-radius:12px;
        background:rgba(255,255,255,.7);
        display:flex; align-items:center; justify-content:center;
        font-size:1.4rem; flex-shrink:0;
    }
    .status-banner.status-success .status-banner-icon { color:#10b981; }
    .status-banner.status-danger  .status-banner-icon { color:#ef4444; }
    .status-banner.status-warning .status-banner-icon { color:#f59e0b; }
    .status-banner-label { font-size:.72rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:.05em; }
    .status-banner-value { font-size:1rem; font-weight:800; color:var(--text); }

    /* ── Detail Section ── */
    .detail-section {
        background:var(--surface-2); border:1px solid var(--border);
        border-radius:var(--radius-sm); padding:1.1rem; height:100%;
    }
    .detail-section-title {
        font-size:.82rem; font-weight:700; color:var(--text-muted);
        text-transform:uppercase; letter-spacing:.05em;
        margin-bottom:.75rem; padding-bottom:.6rem;
        border-bottom:1px solid var(--border);
    }
    .detail-row {
        display:flex; justify-content:space-between; align-items:center;
        padding:.5rem 0; border-bottom:1px solid var(--border); gap:.5rem;
    }
    .detail-label { font-size:.8rem; color:var(--text-muted); flex-shrink:0; }
    .detail-value { font-size:.85rem; color:var(--text); text-align:right; }

    /* ── NIP Badge ── */
    .nip-badge {
        background:#f1f5f9; color:#334155;
        padding:.25rem .75rem; border-radius:6px;
        font-size:.78rem; font-weight:700;
        font-family: monospace;
        border:1px solid #e2e8f0;
    }

    /* ── Hari Badge ── */
    .hari-badge {
        background:#eff6ff; color:#1d4ed8;
        padding:.25rem .75rem; border-radius:99px;
        font-size:.78rem; font-weight:700;
    }

    /* ── Sisa Cuti Pill ── */
    .sisa-pill { display:inline-block; padding:.25rem .85rem; border-radius:99px; font-size:.8rem; font-weight:700; }
    .sisa-ok    { background:#ecfdf5; color:#047857; border:1px solid #6ee7b7; }
    .sisa-warn  { background:#fffbeb; color:#92400e; border:1px solid #fcd34d; }
    .sisa-empty { background:#fef2f2; color:#b91c1c; border:1px solid #fca5a5; }

    /* ── Alasan & Catatan Box ── */
    .alasan-box {
        background:var(--surface-2); border:1px solid var(--border);
        border-left:4px solid var(--primary); border-radius:var(--radius-xs);
        padding:1rem 1.25rem; font-size:.875rem; line-height:1.6;
    }
    .catatan-box {
        background:#fffbeb; border:1px solid #fcd34d;
        border-left:4px solid #f59e0b; border-radius:var(--radius-xs);
        padding:1rem 1.25rem; font-size:.875rem; color:#92400e; line-height:1.6;
    }

    /* ── Modal Info Box ── */
    .approve-info-box {
        background:#f0fdf4; border:1px solid #bbf7d0;
        border-radius:10px; padding:.9rem 1rem;
    }
    .reject-info-box {
        background:#fef2f2; border:1px solid #fecaca;
        border-radius:10px; padding:.9rem 1rem;
    }
    .approve-avatar {
        width:40px; height:40px; border-radius:50%;
        background:linear-gradient(135deg,#2563eb,#7c3aed);
        display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:.85rem; color:#fff; flex-shrink:0;
    }

    /* ── Badge Opsional ── */
    .badge-opsional {
        background:#f1f5f9; color:#64748b; font-size:.68rem;
        font-weight:600; padding:.2rem .55rem; border-radius:99px;
        margin-left:.4rem; vertical-align:middle;
    }

    .fw-700 { font-weight:700 !important; }
</style>
@endsection