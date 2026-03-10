@extends('layouts.app')

@section('title', 'Pengajuan Cuti')
@section('page-title', 'Pengajuan Cuti')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-inbox me-2"></i>Daftar Pengajuan Cuti
        </h5>
        <form action="{{ route('atasan.pengajuan.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <select name="status" class="form-select" style="width: 150px;">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <select name="jenis_cuti" class="form-select" style="width: 150px;">
                <option value="">Semua Jenis</option>
                <option value="cuti_tahunan" {{ request('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                <option value="cuti_sakit" {{ request('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                <option value="izin" {{ request('jenis_cuti') == 'izin' ? 'selected' : '' }}>Izin</option>
            </select>
            <input type="date" name="tanggal_mulai" class="form-control" style="width: 150px;"
                   value="{{ request('tanggal_mulai') }}" placeholder="Dari Tanggal">
            <input type="date" name="tanggal_selesai" class="form-control" style="width: 150px;"
                   value="{{ request('tanggal_selesai') }}" placeholder="Sampai Tanggal">
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pegawai</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $cuti)
                    <tr>
                        <td>{{ $pengajuan->firstItem() + $index }}</td>
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
                            <span class="badge badge-{{ $cuti->status_badge }}">
                                {{ $cuti->status_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('atasan.pengajuan.show', $cuti) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Tidak ada pengajuan cuti</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3">
            {{ $pengajuan->links() }}
        </div>
    </div>
</div>
@endsection
