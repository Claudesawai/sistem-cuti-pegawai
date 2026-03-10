@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i>Profil Pegawai
                </h5>
            </div>
            <div class="card-body text-center">
                
                <!-- Avatar -->
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" 
                     style="width: 100px; height: 100px; background: #1e3a8a; color: white; border-radius: 50%; font-size: 40px; font-weight: bold;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                
                <!-- Nama -->
                <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                <p class="text-muted mb-3">{{ auth()->user()->jabatan ?? 'Jabatan belum diisi' }}</p>
                
                <!-- Info Detail -->
                <table class="table table-bordered text-start">
                    <tr>
                        <td width="35%" class="fw-bold bg-light">NIP</td>
                        <td>{{ auth()->user()->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Email</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Role</td>
                        <td>
                            <span class="badge bg-{{ auth()->user()->role == 'admin' ? 'danger' : (auth()->user()->role == 'atasan' ? 'warning' : 'info') }}">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Sisa Cuti</td>
                        <td>
                            @if(auth()->user()->role == 'pegawai')
                                <span class="badge bg-{{ auth()->user()->sisa_cuti > 5 ? 'success' : (auth()->user()->sisa_cuti > 0 ? 'warning' : 'danger') }}">
                                    {{ auth()->user()->sisa_cuti }} hari
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <!-- Tombol Kembali -->
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                
            </div>
        </div>
    </div>
</div>
@endsection