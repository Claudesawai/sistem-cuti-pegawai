@extends('layouts.app')

@section('title', 'Detail Pengajuan')
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
                        <h6 class="text-muted mb-2">Informasi Pegawai</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Nama</td>
                                <td>: <strong>{{ $cuti->user->name }}</strong></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $cuti->user->email }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>: {{ $cuti->user->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Sisa Cuti</td>
                                <td>: <span class="badge badge-{{ $cuti->user->sisa_cuti > 5 ? 'success' : ($cuti->user->sisa_cuti > 0 ? 'warning' : 'danger') }}">{{ $cuti->user->sisa_cuti }} hari</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Cuti</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Jenis Cuti</td>
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

                @if($cuti->approver)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Informasi Persetujuan</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Disetujui/Ditolak Oleh</td>
                            <td>: {{ $cuti->approver->name }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: {{ $cuti->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                @endif

                @if($cuti->status === 'menunggu')
                <hr class="my-4">
                
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="bi bi-check-circle me-2"></i>Setujui
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-2"></i>Tolak
                    </button>
                    <a href="{{ route('atasan.pengajuan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                @else
                <div class="d-flex justify-content-end">
                    <a href="{{ route('atasan.pengajuan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Approve Modal --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Persetujuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('atasan.pengajuan.approve', $cuti) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui pengajuan cuti ini?</p>
                    @if($cuti->jenis_cuti === 'cuti_tahunan' && $cuti->user->sisa_cuti < $cuti->jumlah_hari)
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Perhatian!</strong> Sisa cuti pegawai tidak mencukupi. 
                            Sisa cuti: {{ $cuti->user->sisa_cuti }} hari, sedangkan pengajuan: {{ $cuti->jumlah_hari }} hari.
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('atasan.pengajuan.reject', $cuti) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pengajuan cuti ini?</p>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" name="catatan" rows="3" required></textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
