@extends('layouts.app')

@section('title', 'Riwayat Cuti')
@section('page-title', 'Riwayat Cuti')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan Cuti
        </h5>
        <form action="{{ route('pegawai.cuti.riwayat') }}" method="GET" class="d-flex gap-2">
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
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $cuti)
                    <tr>
                        <td>{{ $riwayat->firstItem() + $index }}</td>
                        <td>{{ $cuti->jenis_cuti_label }}</td>
                        <td>{{ $cuti->tanggal_mulai->format('d/m/Y') }}</td>
                        <td>{{ $cuti->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $cuti->jumlah_hari }} hari</td>
                        <td>
                            <span class="badge badge-{{ $cuti->status_badge }}">
                                {{ $cuti->status_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pegawai.cuti.show', $cuti) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Belum ada riwayat pengajuan</h5>
                                <p>Ajukan cuti pertama Anda sekarang</p>
                                <a href="{{ route('pegawai.cuti.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-2"></i>Ajukan Cuti
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>
@endsection
