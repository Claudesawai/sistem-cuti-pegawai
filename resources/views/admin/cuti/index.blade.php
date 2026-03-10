@extends('layouts.app')

@section('title', 'Data Cuti')
@section('page-title', 'Data Cuti')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-calendar-event me-2"></i>Daftar Pengajuan Cuti
        </h5>
        <div class="d-flex gap-2 flex-wrap">
            <form action="{{ route('admin.cuti.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
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
                <select name="bulan" class="form-select" style="width: 130px;">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="form-select" style="width: 120px;">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <select name="user_id" class="form-select" style="width: 180px;">
                    <option value="">Semua Pegawai</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-2"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.cuti.export.pdf', request()->all()) }}">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.cuti.export.excel', request()->all()) }}">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NAMA</th>
                        <th>Nomor Induk Pegawai</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Disetujui Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuti as $index => $c)
                    <tr>
                        <td>{{ $cuti->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                </div>
                                <span>{{ $c->user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $c->user->nip ?? '-' }}</td>
                        <td>{{ $c->jenis_cuti_label }}</td>
                        <td>{{ $c->tanggal_mulai->format('d/m/Y') }}</td>
                        <td>{{ $c->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $c->jumlah_hari }} hari</td>
                        <td>
                            <span class="badge badge-{{ $c->status_badge }}">
                                {{ $c->status_label }}
                            </span>
                        </td>
                        <td>
                            @if($c->approver)
                                {{ $c->approver->name }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Tidak ada data cuti</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $cuti->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection