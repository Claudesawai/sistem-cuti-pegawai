@extends('layouts.app')

@section('title', 'Pengajuan Cuti')
@section('page-title', 'Pengajuan Cuti')

@section('content')

<div class="card">

    {{-- ── Header + Filter ── --}}
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

            <h5 class="card-title mb-0">Daftar Pengajuan Cuti</h5>

            <form action="{{ route('atasan.pengajuan.index') }}"
                  method="GET"
                  class="d-flex align-items-center gap-2 flex-wrap">

                <select name="status" class="form-select form-select-sm filter-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu"
                        {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui"
                        {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"
                        {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <select name="jenis_cuti" class="form-select form-select-sm filter-select">
                    <option value="">Semua Jenis</option>
                    <option value="cuti_tahunan"
                        {{ request('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                    <option value="cuti_sakit"
                        {{ request('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                    <option value="izin"
                        {{ request('jenis_cuti') == 'izin' ? 'selected' : '' }}>Izin</option>
                </select>

                <input type="date" name="tanggal_mulai"
                       class="form-control form-control-sm filter-select"
                       value="{{ request('tanggal_mulai') }}">

                <input type="date" name="tanggal_selesai"
                       class="form-control form-control-sm filter-select"
                       value="{{ request('tanggal_selesai') }}">

                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-search me-1"></i>Filter
                </button>

                @if(request('status') || request('jenis_cuti') || request('tanggal_mulai') || request('tanggal_selesai'))
                    <a href="{{ route('atasan.pengajuan.index') }}"
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
                        <th>Pegawai</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $cuti)
                    <tr>
                        <td>
                            <span class="nomor-urut">
                                {{ $pengajuan->firstItem() + $index }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="tbl-avatar">
                                    {{ strtoupper(substr($cuti->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-600" style="font-size:.875rem;">
                                        {{ $cuti->user->name }}
                                    </div>
                                    {{-- NIP ditampilkan di bawah nama ── --}}
                                    <div style="font-size:.72rem; color:var(--text-muted);">
                                        NIP: {{ $cuti->user->nip ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:.83rem;">{{ $cuti->jenis_cuti_label }}</span>
                        </td>
                        <td>
                            <span class="tgl-badge">
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
                        <td>
                            <a href="{{ route('atasan.pengajuan.show', $cuti) }}"
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
                                <h5>Tidak ada pengajuan cuti</h5>
                                <p>
                                    @if(request()->hasAny(['status','jenis_cuti','tanggal_mulai','tanggal_selesai']))
                                        Tidak ada data sesuai filter yang dipilih
                                    @else
                                        Belum ada pengajuan cuti dari pegawai
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pengajuan->hasPages())
            <div class="px-4 py-3 border-top d-flex align-items-center
                        justify-content-between flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $pengajuan->firstItem() }}–{{ $pengajuan->lastItem() }}
                    dari {{ $pengajuan->total() }} data
                </small>
                {{ $pengajuan->links() }}
            </div>
        @endif

    </div>
</div>

@endsection

@section('styles')
<style>
    .filter-select { width: 140px; font-size:.82rem; }

    .nomor-urut {
        display:inline-flex; align-items:center; justify-content:center;
        width:28px; height:28px; background:var(--surface-2);
        border:1px solid var(--border); border-radius:6px;
        font-size:.78rem; font-weight:600; color:var(--text-muted);
    }

    .tbl-avatar {
        width:36px; height:36px; border-radius:50%;
        background:linear-gradient(135deg,#2563eb,#7c3aed);
        display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:.8rem; color:white; flex-shrink:0;
    }

    .tgl-badge {
        font-size:.78rem; color:#64748b; background:#f1f5f9;
        padding:.25rem .65rem; border-radius:99px; white-space:nowrap;
    }

    .hari-badge {
        background:#eff6ff; color:#1d4ed8;
        padding:.25rem .65rem; border-radius:99px;
        font-size:.75rem; font-weight:700;
    }

    .fw-600 { font-weight:600; }
</style>
@endsection