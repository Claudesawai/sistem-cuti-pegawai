@extends('layouts.app')

@section('title', 'Dashboard Atasan')
@section('page-title', 'Dashboard Atasan')

@section('content')
<div class="row g-4 mb-4">
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
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-value">{{ $totalPengajuan }}</div>
            <div class="stat-label">Total Pengajuan</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-inbox me-2"></i>Pengajuan Menunggu Persetujuan
                </h5>
                <a href="{{ route('atasan.pengajuan.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pegawai</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hari</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $cuti)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                {{ strtoupper(substr($cuti->user->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $cuti->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $cuti->jenis_cuti_label }}</td>
                                    <td>
                                        {{ $cuti->tanggal_mulai->format('d/m/Y') }} - 
                                        {{ $cuti->tanggal_selesai->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $cuti->jumlah_hari }} hari</td>
                                    <td>
                                        <a href="{{ route('atasan.pengajuan.show', $cuti) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-check-circle"></i>
                        <h5>Tidak ada pengajuan menunggu</h5>
                        <p>Semua pengajuan cuti sudah diproses</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Statistik Jenis Cuti
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Cuti Tahunan</span>
                    <span class="badge badge-info">{{ $cutiTahunan }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Cuti Sakit</span>
                    <span class="badge badge-warning">{{ $cutiSakit }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Izin</span>
                    <span class="badge badge-success">{{ $izin }}</span>
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
                <a href="{{ route('atasan.pengajuan.index') }}?status=menunggu" class="btn btn-outline-warning w-100 mb-2">
                    <i class="bi bi-hourglass-split me-2"></i>Pengajuan Menunggu
                </a>
                <a href="{{ route('atasan.pengajuan.index') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-list me-2"></i>Semua Pengajuan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
