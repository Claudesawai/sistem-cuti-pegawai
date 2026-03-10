@extends('layouts.app')

@section('title', 'Dashboard Pegawai')
@section('page-title', 'Dashboard Pegawai')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $sisaCuti }}</div>
            <div class="stat-label">Sisa Cuti Tahunan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value">{{ $cutiMenunggu }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value">{{ $cutiDisetujui }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-value">{{ $cutiDitolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan Terbaru
                </h5>
                <a href="{{ route('pegawai.cuti.riwayat') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
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
                                    <td>{{ $cuti->jenis_cuti_label }}</td>
                                    <td>
                                        {{ $cuti->tanggal_mulai->format('d/m/Y') }} - 
                                        {{ $cuti->tanggal_selesai->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $cuti->jumlah_hari }} hari</td>
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
                        <i class="bi bi-inbox"></i>
                        <h5>Belum ada riwayat pengajuan</h5>
                        <p>Ajukan cuti pertama Anda sekarang</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informasi Cuti
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Jatah Cuti Tahunan</small>
                    <strong>12 hari</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Sisa Cuti</small>
                    <strong class="text-primary">{{ $sisaCuti }} hari</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Total Pengajuan</small>
                    <strong>{{ $totalPengajuan }} pengajuan</strong>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning me-2"></i>Akses Cepat
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('pegawai.cuti.create') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-plus-circle me-2"></i>Ajukan Cuti
                </a>
                <a href="{{ route('pegawai.cuti.sisa') }}" class="btn btn-outline-info w-100 mb-2">
                    <i class="bi bi-calendar-check me-2"></i>Cek Sisa Cuti
                </a>
                <a href="{{ route('pegawai.cuti.riwayat') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Cuti
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
