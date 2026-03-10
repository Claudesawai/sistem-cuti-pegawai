@extends('layouts.app')

@section('title', 'Sisa Cuti')
@section('page-title', 'Sisa Cuti Tahunan')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon primary mx-auto" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h2 class="mt-3 mb-1">{{ $sisaCuti }}</h2>
                <p class="text-muted mb-0">Sisa Cuti Tahunan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon success mx-auto" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-calendar-plus"></i>
                </div>
                <h2 class="mt-3 mb-1">{{ $jatahCuti }}</h2>
                <p class="text-muted mb-0">Jatah Cuti Tahunan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon warning mx-auto" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-calendar-minus"></i>
                </div>
                <h2 class="mt-3 mb-1">{{ $cutiTerpakai }}</h2>
                <p class="text-muted mb-0">Cuti Terpakai</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history me-2"></i>Riwayat Penggunaan Cuti Tahunan
        </h5>
    </div>
    <div class="card-body p-0">
        @if($riwayatCutiTahunan->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Periode Cuti</th>
                            <th>Jumlah Hari</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatCutiTahunan as $index => $cuti)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cuti->created_at->format('d/m/Y') }}</td>
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
                <h5>Belum ada riwayat penggunaan cuti tahunan</h5>
                <p>Anda belum pernah mengajukan cuti tahunan</p>
            </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-info-circle me-2"></i>Informasi Cuti
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-3">Ketentuan Cuti Tahunan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Jatah cuti tahunan: 12 hari</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Cuti dapat diambil secara bertahap</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Sisa cuti tidak dapat diakumulasi ke tahun berikutnya</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="mb-3">Ketentuan Cuti Sakit & Izin</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Cuti sakit wajib melampirkan surat keterangan dokter</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Izin dapat diajukan untuk keperluan penting</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Tidak mengurangi sisa cuti tahunan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
