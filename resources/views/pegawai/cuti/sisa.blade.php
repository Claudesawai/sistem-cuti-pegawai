@extends('layouts.app')

@section('title', 'Sisa Cuti')
@section('page-title', 'Sisa Cuti Tahunan')

@section('content')

{{-- ── Breadcrumb ── --}}
<nav class="mb-3" style="font-size:.82rem;">
    <a href="{{ route('pegawai.dashboard') }}"
       style="color:var(--text-muted); text-decoration:none;">
        <i class="bi bi-house me-1"></i>Dashboard
    </a>
    <span class="mx-2" style="color:var(--text-light);">/</span>
    <span style="color:var(--text); font-weight:600;">Sisa Cuti</span>
</nav>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $sisaCuti }}</div>
            <div class="stat-label">Sisa Cuti Tahunan</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-icon success">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <div class="stat-value">{{ $jatahCuti }}</div>
            <div class="stat-label">Jatah Cuti Tahunan</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="stat-icon warning">
                <i class="bi bi-calendar-minus"></i>
            </div>
            <div class="stat-value">{{ $cutiTerpakai }}</div>
            <div class="stat-label">Cuti Terpakai</div>
        </div>
    </div>

</div>

{{-- ── Progress Kuota ── --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size:.85rem; font-weight:600; color:var(--text);">
                Penggunaan Kuota Cuti Tahunan
            </span>
            <span style="font-size:.85rem; font-weight:700; color:var(--primary);">
                {{ $cutiTerpakai }} / {{ $jatahCuti }} hari
                ({{ $jatahCuti > 0 ? round(($cutiTerpakai / $jatahCuti) * 100) : 0 }}%)
            </span>
        </div>
        <div class="progress-track-lg">
            <div class="progress-fill-lg"
                 style="width: {{ $jatahCuti > 0 ? round(($cutiTerpakai / $jatahCuti) * 100) : 0 }}%">
            </div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <small class="text-muted">0 hari</small>
            <small class="text-muted">{{ $jatahCuti }} hari</small>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- ── Riwayat Penggunaan Cuti ── --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Penggunaan Cuti Tahunan</h5>
            </div>
            <div class="card-body p-0">

                @if($riwayatCutiTahunan->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Periode Cuti</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatCutiTahunan as $index => $cuti)
                                <tr>
                                    <td>
                                        <span class="nomor-urut">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size:.83rem; color:var(--text-muted);">
                                            {{ $cuti->created_at->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size:.83rem;">
                                            <i class="bi bi-arrow-right"
                                               style="color:var(--text-light); font-size:.7rem;"></i>
                                            {{ $cuti->tanggal_mulai->format('d/m/Y') }}
                                            <span style="color:var(--text-light); margin:0 4px;">—</span>
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
                        <h5>Belum ada riwayat cuti tahunan</h5>
                        <p>Anda belum pernah mengajukan cuti tahunan</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ── Informasi Ketentuan ── --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi & Ketentuan</h5>
            </div>
            <div class="card-body">

                {{-- Cuti Tahunan --}}
                <div class="ketentuan-group">
                    <div class="ketentuan-title">
                        <i class="bi bi-calendar-check me-2" style="color:var(--primary);"></i>
                        Cuti Tahunan
                    </div>
                    <ul class="ketentuan-list">
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Jatah cuti tahunan: <strong>12 hari</strong>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Dapat diambil secara bertahap
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Sisa cuti tidak diakumulasi ke tahun berikutnya
                        </li>
                    </ul>
                </div>

                <div class="ketentuan-divider"></div>

                {{-- Cuti Sakit & Izin --}}
                <div class="ketentuan-group" style="margin-bottom:0;">
                    <div class="ketentuan-title">
                        <i class="bi bi-heart-pulse me-2" style="color:#ef4444;"></i>
                        Cuti Sakit & Izin
                    </div>
                    <ul class="ketentuan-list">
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Wajib lampirkan surat keterangan dokter
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Izin untuk keperluan penting
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            Tidak mengurangi sisa cuti tahunan
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    /* ── Progress Bar Besar ── */
    .progress-track-lg {
        height: 14px;
        background: #e2e8f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill-lg {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        transition: width 1s ease;
        min-width: 4px;
    }

    /* ── Nomor Urut ── */
    .nomor-urut {
        display: inline-flex;
        align-items: center; justify-content: center;
        width: 28px; height: 28px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* ── Hari Badge ── */
    .hari-badge {
        background: #eff6ff;
        color: #1d4ed8;
        padding: .25rem .65rem;
        border-radius: 99px;
        font-size: .75rem;
        font-weight: 700;
    }

    /* ── Ketentuan ── */
    .ketentuan-group { margin-bottom: 1rem; }

    .ketentuan-title {
        font-size: .83rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: .75rem;
    }

    .ketentuan-list {
        list-style: none;
        padding: 0; margin: 0;
    }

    .ketentuan-list li {
        display: flex;
        align-items: flex-start;
        gap: .5rem;
        font-size: .82rem;
        color: var(--text-muted);
        padding: .35rem 0;
        border-bottom: 1px solid var(--border);
    }

    .ketentuan-list li:last-child { border: none; }

    .ketentuan-list li i {
        font-size: .8rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .ketentuan-divider {
        height: 1px;
        background: var(--border);
        margin: 1rem 0;
    }
</style>
@endsection