@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- ── Breadcrumb ── --}}
        <nav class="mb-3" style="font-size:.82rem;">
            <a href="{{ url()->previous() }}"
               style="color:var(--text-muted); text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <span class="mx-2" style="color:var(--text-light);">/</span>
            <span style="color:var(--text); font-weight:600;">Profil Saya</span>
        </nav>

        {{-- ── Profile Hero Card ── --}}
        <div class="card overflow-hidden mb-4">

            {{-- Cover --}}
            <div class="profile-cover"></div>

            {{-- Avatar & Nama --}}
            <div class="card-body text-center pb-4" style="margin-top: -40px;">
                <div class="profile-avatar mx-auto mb-3">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <h4 class="fw-800 mb-1" style="font-size:1.2rem;">
                    {{ auth()->user()->name }}
                </h4>
                <p class="text-muted mb-2" style="font-size:.85rem;">
                    {{ auth()->user()->jabatan ?? 'Jabatan belum diisi' }}
                </p>
                {{-- Role Badge --}}
                @php
                    $roleBadge = match(auth()->user()->role) {
                        'admin'   => ['bg:#fef2f2;color:#b91c1c;border:1px solid #fecaca;', 'Admin'],
                        'atasan'  => ['bg:#fffbeb;color:#92400e;border:1px solid #fcd34d;', 'Atasan'],
                        default   => ['bg:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;', 'Pegawai'],
                    };
                @endphp
                <span style="display:inline-block; padding:.3rem .9rem; border-radius:99px;
                             font-size:.75rem; font-weight:700;
                             background:{{ explode(';', $roleBadge[0])[0] }};
                             color:{{ explode('color:', $roleBadge[0])[1] }};
                             border:{{ explode('border:', $roleBadge[0])[1] }}">
                    {{ $roleBadge[1] }}
                </span>
            </div>
        </div>

        {{-- ── Detail Info ── --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Akun</h5>
            </div>
            <div class="card-body p-0">

                {{-- NIP --}}
                <div class="profil-row">
                    <div class="profil-icon-wrap" style="background:#eff6ff; color:#2563eb;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="profil-info">
                        <div class="profil-label">NIP</div>
                        <div class="profil-value">{{ auth()->user()->nip ?? '-' }}</div>
                    </div>
                </div>

                {{-- Email --}}
                <div class="profil-row">
                    <div class="profil-icon-wrap" style="background:#f0fdf4; color:#10b981;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="profil-info">
                        <div class="profil-label">Email</div>
                        <div class="profil-value">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                {{-- Role --}}
                <div class="profil-row">
                    <div class="profil-icon-wrap" style="background:#fdf4ff; color:#9333ea;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="profil-info">
                        <div class="profil-label">Role / Jabatan Sistem</div>
                        <div class="profil-value">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>

                {{-- Sisa Cuti (hanya pegawai) --}}
                @if(auth()->user()->role == 'pegawai')
                <div class="profil-row" style="border-bottom:none;">
                    <div class="profil-icon-wrap"
                         style="background:{{ auth()->user()->sisa_cuti > 5 ? '#f0fdf4' : (auth()->user()->sisa_cuti > 0 ? '#fffbeb' : '#fef2f2') }};
                                color:{{ auth()->user()->sisa_cuti > 5 ? '#10b981' : (auth()->user()->sisa_cuti > 0 ? '#f59e0b' : '#ef4444') }};">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="profil-info">
                        <div class="profil-label">Sisa Cuti Tahunan</div>
                        <div class="profil-value">
                            <span class="sisa-pill
                                {{ auth()->user()->sisa_cuti > 5 ? 'sisa-ok' : (auth()->user()->sisa_cuti > 0 ? 'sisa-warn' : 'sisa-empty') }}">
                                {{ auth()->user()->sisa_cuti }} hari
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="profil-row" style="border-bottom:none;">
                    <div class="profil-icon-wrap" style="background:#f1f5f9; color:#94a3b8;">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="profil-info">
                        <div class="profil-label">Sisa Cuti Tahunan</div>
                        <div class="profil-value text-muted">—</div>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- ── Tombol Kembali ── --}}
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Cover ── */
    .profile-cover {
        height: 110px;
        background: linear-gradient(135deg, #1e293b 0%, #1e40af 60%, #3b82f6 100%);
    }

    /* ── Avatar ── */
    .profile-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 800; color: #fff;
        border: 4px solid #fff;
        box-shadow: 0 4px 16px rgba(37,99,235,.3);
    }

    .fw-800 { font-weight: 800 !important; }

    /* ── Profil Rows ── */
    .profil-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .profil-row:hover { background: var(--surface-2); }

    .profil-icon-wrap {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .profil-label {
        font-size: .75rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 2px;
    }

    .profil-value {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
    }

    /* ── Sisa Cuti Pill ── */
    .sisa-pill {
        display: inline-block;
        padding: .25rem .85rem;
        border-radius: 99px;
        font-size: .8rem;
        font-weight: 700;
    }

    .sisa-ok    { background:#ecfdf5; color:#047857; border:1px solid #6ee7b7; }
    .sisa-warn  { background:#fffbeb; color:#92400e; border:1px solid #fcd34d; }
    .sisa-empty { background:#fef2f2; color:#b91c1c; border:1px solid #fca5a5; }
</style>
@endsection