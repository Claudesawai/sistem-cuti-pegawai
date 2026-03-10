@extends('layouts.app')

@section('title', 'Data Pegawai')
@section('page-title', 'Data Pegawai')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-people me-2"></i>Daftar Pegawai
        </h5>
        <div class="d-flex gap-2 flex-wrap">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." 
                       value="{{ request('search') }}" style="width: 200px;">
                <select name="role" class="form-select" style="width: 150px;">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="atasan" {{ request('role') == 'atasan' ? 'selected' : '' }}>Atasan</option>
                    <option value="pegawai" {{ request('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                </select>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pegawai
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Role</th>
                        <th>Sisa Cuti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->nip ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->jabatan ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'atasan' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->role == 'pegawai')
                                <span class="badge badge-{{ $user->sisa_cuti > 5 ? 'success' : ($user->sisa_cuti > 0 ? 'warning' : 'danger') }}">
                                    {{ $user->sisa_cuti }} hari
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Tidak ada data pegawai</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection