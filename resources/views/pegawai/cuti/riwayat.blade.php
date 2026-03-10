@extends('layouts.app')

@section('title', 'Riwayat Cuti')
@section('page-title', 'Riwayat Cuti')

@section('content')

{{-- ── Breadcrumb ── --}}
<nav class="mb-3" style="font-size:.82rem;">
    <a href="{{ route('pegawai.dashboard') }}"
       style="color:var(--text-muted); text-decoration:none;">
        <i class="bi bi-house me-1"></i>Dashboard
    </a>
    <span class="mx-2" style="color:var(--text-light);">/</span>
    <span style="color:var(--text); font-weight:600;">Riwayat Cuti</span>
</nav>

<div class="card">

    {{-- ── Header + Filter ── --}}
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

            <h5 class="card-title mb-0">Riwayat Pengajuan Cuti</h5>

            {{-- Form Filter --}}
            <form action="{{ route('pegawai.cuti.riwayat') }}"
                  method="GET"
                  class="d-flex align-items-center gap-2 flex-wrap">

                <select name="status" class="form-select form-select-sm filter-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu"
                        {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="disetujui"
                        {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>
                    <option value="ditolak"
                        {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                </select>

                <select name="jenis_cuti" class="form-select form-select-sm filter-select">
                    <option value="">Semua Jenis</option>
                    <option value="cuti_tahunan"
                        {{ request('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>
                        Cuti Tahunan
                    </option>
                    <option value="cuti_sakit"
                        {{ request('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>
                        Cuti Sakit
                    </option>
                    <option value="izin"
                        {{ request('jenis_cuti') == 'izin' ? 'selected' : '' }}>
                        Izin
                    </option>
                </select>

                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-search me-1"></i>Filter
                </button>

                @if(request('status') || request('jenis_cuti'))
                    <a href="{{ route('pegawai.cuti.riwayat') }}"
                       class="btn btn-outline-secondary btn-sm px-3">
                        <i class="bi bi-x-circle me-1"></i>Reset
                    </a>
                @endif

            </form>
        </div>
    </div>

    {{-- ── Tabel ── --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $cuti)
                    <tr>
                        <td>
                            <span class="nomor-urut">
                                {{ $riwayat->firstItem() + $index }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-600">{{ $cuti->jenis_cuti_label }}</span>
                        </td>
                        <td>
                            <span class="tgl-text">
                                <i class="bi bi-calendar3 me-1"
                                   style="color:var(--text-light);"></i>
                                {{ $cuti->tanggal_mulai->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="tgl-text">
                                <i class="bi bi-calendar3 me-1"
                                   style="color:var(--text-light);"></i>
                                {{ $cuti->tanggal_selesai->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="hari-badge">
                                {{ $cuti->jumlah_hari }} hari
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $cuti->status_badge }}">
                                {{ $cuti->status_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pegawai.cuti.show', $cuti) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <h5>Belum ada riwayat pengajuan</h5>
                                <p>
                                    @if(request('status') || request('jenis_cuti'))
                                        Tidak ada data yang sesuai dengan filter yang dipilih
                                    @else
                                        Ajukan cuti pertama Anda sekarang
                                    @endif
                                </p>
                                @if(!request('status') && !request('jenis_cuti'))
                                    <a href="{{ route('pegawai.cuti.create') }}"
                                       class="btn btn-primary btn-sm mt-3">
                                        <i class="bi bi-plus-circle me-2"></i>Ajukan Cuti
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($riwayat->hasPages())
            <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between
                        flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }}
                    dari {{ $riwayat->total() }} data
                </small>
                {{ $riwayat->links() }}
            </div>
        @endif

    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Filter Select ── */
    .filter-select {
        width: 145px;
        font-size: .82rem;
    }

    /* ── Nomor urut ── */
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

    /* ── Tanggal ── */
    .tgl-text {
        font-size: .83rem;
        color: var(--text-muted);
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

    /* ── Utility ── */
    .fw-600 { font-weight: 600; }
</style>
@endsection