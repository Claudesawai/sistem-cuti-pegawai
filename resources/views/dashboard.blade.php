@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Header Dashboard -->
    <div class="dashboard-header text-center">
        <h1 class="dashboard-title">
            <i class="fas fa-tachometer-alt"></i> DASHBOARD
        </h1>
        <p class="dashboard-subtitle">
            Sistem Informasi Cuti Pegawai Pemerintah Kabupaten Bima
        </p>
    </div>

    <!-- Info User -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-pemkab">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : asset('images/default-user.png') }}" 
                             alt="Foto" class="rounded-circle" width="80" height="80"
                             onerror="this.src='https://via.placeholder.com/80/1e5631/ffffff?text={{ substr(auth()->user()->name, 0, 1) }}'">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-1">Selamat Datang, {{ auth()->user()->name }}</h4>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-id-card"></i> NIP: {{ auth()->user()->nip ?? '-' }} | 
                            <i class="fas fa-briefcase"></i> {{ auth()->user()->jabatan->nama ?? '-' }} |
                            <span class="badge bg-success">{{ ucfirst(auth()->user()->role) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        @if(auth()->user()->role == 'pegawai')
        <!-- Statistik Pegawai -->
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                    <h3>{{ $sisaCuti ?? 12 }}</h3>
                    <p class="text-muted">Sisa Cuti Tahunan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h3>{{ $cutiMenunggu ?? 0 }}</h3>
                    <p class="text-muted">Pengajuan Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-info mb-3"></i>
                    <h3>{{ $cutiDisetujui ?? 0 }}</h3>
                    <p class="text-muted">Cuti Disetujui</p>
                </div>
            </div>
        </div>
        
        @elseif(auth()->user()->role == 'atasan')
        <!-- Statistik Atasan -->
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3>{{ $jumlahBawahan ?? 0 }}</h3>
                    <p class="text-muted">Jumlah Staff</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-3x text-warning mb-3"></i>
                    <h3>{{ $pendingApproval ?? 0 }}</h3>
                    <p class="text-muted">Menunggu Approval</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h3>{{ $totalCutiBulan ?? 0 }}</h3>
                    <p class="text-muted">Cuti Bulan Ini</p>
                </div>
            </div>
        </div>
        
        @elseif(auth()->user()->role == 'admin')
        <!-- Statistik Admin -->
        <div class="col-md-3">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3>{{ $totalPegawai ?? 0 }}</h3>
                    <p class="text-muted">Total Pegawai</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-3x text-warning mb-3"></i>
                    <h3>{{ $totalMenunggu ?? 0 }}</h3>
                    <p class="text-muted">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-double fa-3x text-success mb-3"></i>
                    <h3>{{ $totalDisetujui ?? 0 }}</h3>
                    <p class="text-muted">Disetujui Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pemkab h-100">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h3>{{ $totalDitolak ?? 0 }}</h3>
                    <p class="text-muted">Ditolak Bulan Ini</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Tombol Cepat -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-pemkab">
                <div class="card-header card-header-pemkab">
                    <i class="fas fa-bolt"></i> Akses Cepat
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cuti.create') }}" class="btn btn-pemkab w-100">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Ajukan Cuti
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cuti.index') }}" class="btn btn-pemkab w-100">
                                <i class="fas fa-history fa-2x d-block mb-2"></i>
                                Riwayat Cuti
                            </a>
                        </div>
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'atasan')
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cuti.approval') }}" class="btn btn-pemkab w-100">
                                <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                                Approval Cuti
                            </a>
                        </div>
                        @endif
                        @if(auth()->user()->role == 'admin')
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-pemkab w-100">
                                <i class="fas fa-file-export fa-2x d-block mb-2"></i>
                                Export Laporan
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection