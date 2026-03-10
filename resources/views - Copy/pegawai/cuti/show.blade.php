@extends('layouts.app')

@section('title', 'Detail Cuti')
@section('page-title', 'Detail Pengajuan Cuti')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan Cuti
                </h5>
                <span class="badge badge-{{ $cuti->status_badge }} fs-6">
                    {{ $cuti->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Cuti</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150">Jenis Cuti</td>
                                <td>: <strong>{{ $cuti->jenis_cuti_label }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td>: {{ $cuti->tanggal_mulai->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai</td>
                                <td>: {{ $cuti->tanggal_selesai->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Hari</td>
                                <td>: <strong>{{ $cuti->jumlah_hari }} hari</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Pengajuan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150">Tanggal Pengajuan</td>
                                <td>: {{ $cuti->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: <span class="badge badge-{{ $cuti->status_badge }}">{{ $cuti->status_label }}</span></td>
                            </tr>
                            @if($cuti->approver)
                            <tr>
                                <td>{{ $cuti->status == 'disetujui' ? 'Disetujui' : 'Ditolak' }} Oleh</td>
                                <td>: {{ $cuti->approver->name }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ $cuti->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted mb-2">Alasan Cuti</h6>
                    <div class="p-3 bg-light rounded">
                        {{ $cuti->alasan }}
                    </div>
                </div>

                @if($cuti->file_pendukung)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">File Pendukung</h6>
                    <a href="{{ asset('storage/' . $cuti->file_pendukung) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark me-2"></i>Lihat File
                    </a>
                </div>
                @endif

                @if($cuti->catatan_atasan)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Catatan Atasan</h6>
                    <div class="p-3 bg-light rounded">
                        {{ $cuti->catatan_atasan }}
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-end">
                    <a href="{{ route('pegawai.cuti.riwayat') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
