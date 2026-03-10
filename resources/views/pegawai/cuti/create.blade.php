@extends('layouts.app')

@section('title', 'Ajukan Cuti')
@section('page-title', 'Ajukan Cuti')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- ── Breadcrumb ── --}}
        <nav class="mb-3" style="font-size:.82rem;">
            <a href="{{ route('pegawai.dashboard') }}"
               style="color:var(--text-muted); text-decoration:none;">
                <i class="bi bi-house me-1"></i>Dashboard
            </a>
            <span class="mx-2" style="color:var(--text-light);">/</span>
            <span style="color:var(--text); font-weight:600;">Ajukan Cuti</span>
        </nav>

        {{-- ── Info Sisa Cuti ── --}}
        <div class="sisa-cuti-banner mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="sisa-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div>
                    <div style="font-size:.75rem; color:rgba(255,255,255,.65); font-weight:500;">
                        Sisa Cuti Tahunan Anda
                    </div>
                    <div style="font-size:1.4rem; font-weight:800; color:#fff; line-height:1.2;">
                        {{ $user->sisa_cuti }} hari
                    </div>
                </div>
                <div class="ms-auto">
                    <div class="sisa-pill">
                        <i class="bi bi-info-circle me-1"></i>
                        Dari 12 hari jatah tahunan
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Form Card ── --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Form Pengajuan Cuti
                </h5>
            </div>
            <div class="card-body">

                <form action="{{ route('pegawai.cuti.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Jenis Cuti --}}
                    <div class="mb-4">
                        <label for="jenis_cuti" class="form-label">
                            Jenis Cuti
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('jenis_cuti') is-invalid @enderror"
                                id="jenis_cuti" name="jenis_cuti" required>
                            <option value="">— Pilih Jenis Cuti —</option>
                            <option value="cuti_tahunan"
                                {{ old('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>
                                Cuti Tahunan (Sisa: {{ $user->sisa_cuti }} hari)
                            </option>
                            <option value="cuti_sakit"
                                {{ old('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>
                                Cuti Sakit
                            </option>
                            <option value="izin"
                                {{ old('jenis_cuti') == 'izin' ? 'selected' : '' }}>
                                Izin
                            </option>
                        </select>
                        @error('jenis_cuti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">
                                Tanggal Mulai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                   id="tanggal_mulai" name="tanggal_mulai"
                                   value="{{ old('tanggal_mulai') }}"
                                   required min="{{ date('Y-m-d') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">
                                Tanggal Selesai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                   id="tanggal_selesai" name="tanggal_selesai"
                                   value="{{ old('tanggal_selesai') }}"
                                   required min="{{ date('Y-m-d') }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Preview Jumlah Hari --}}
                    <div class="mb-4">
                        <label for="jumlah_hari" class="form-label">Jumlah Hari</label>
                        <div class="jumlah-preview" id="jumlah_preview">
                            <i class="bi bi-calendar3 me-2" style="color:var(--text-light);"></i>
                            <span id="jumlah_text" style="color:var(--text-muted);">
                                Pilih tanggal mulai dan selesai terlebih dahulu
                            </span>
                        </div>
                        {{-- Hidden input untuk dikirim ke server --}}
                        <input type="hidden" id="jumlah_hari" name="jumlah_hari"
                               value="{{ old('jumlah_hari') }}">
                    </div>

                    {{-- Alasan --}}
                    <div class="mb-4">
                        <label for="alasan" class="form-label">
                            Alasan Cuti
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alasan') is-invalid @enderror"
                                  id="alasan" name="alasan"
                                  rows="4" required
                                  placeholder="Jelaskan alasan cuti Anda secara singkat dan jelas...">{{ old('alasan') }}</textarea>
                        @error('alasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- File Pendukung --}}
                    <div class="mb-5">
                        <label for="file_pendukung" class="form-label">
                            File Pendukung
                            <span class="badge-opsional">Opsional</span>
                        </label>
                        <input type="file"
                               class="form-control @error('file_pendukung') is-invalid @enderror"
                               id="file_pendukung" name="file_pendukung"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <div class="file-hint">
                            <i class="bi bi-paperclip me-1"></i>
                            Format yang diterima: PDF, JPG, JPEG, PNG &mdash; Maksimal 2MB
                        </div>
                        @error('file_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-3 align-items-center">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Ajukan Cuti
                        </button>
                        <a href="{{ route('pegawai.dashboard') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
    /* ── Sisa Cuti Banner ── */
    .sisa-cuti-banner {
        background: linear-gradient(135deg, #1e40af, #2563eb 60%, #3b82f6);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 6px 20px rgba(37,99,235,.3);
    }

    .sisa-icon {
        width: 48px; height: 48px;
        background: rgba(255,255,255,.15);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: #fff;
        flex-shrink: 0;
    }

    .sisa-pill {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.2);
        color: rgba(255,255,255,.85);
        font-size: .75rem;
        font-weight: 500;
        padding: .4rem .9rem;
        border-radius: 99px;
        white-space: nowrap;
    }

    /* ── Jumlah Hari Preview ── */
    .jumlah-preview {
        display: flex;
        align-items: center;
        padding: .75rem 1rem;
        border-radius: var(--radius-xs);
        border: 1.5px dashed var(--border);
        background: var(--surface-2);
        font-size: .875rem;
        min-height: 46px;
        transition: all .3s;
    }

    .jumlah-preview.aktif {
        border-color: var(--primary);
        border-style: solid;
        background: var(--primary-light);
    }

    .jumlah-preview.aktif span {
        color: var(--primary) !important;
        font-weight: 700;
    }

    .jumlah-preview.error {
        border-color: var(--danger);
        border-style: solid;
        background: #fef2f2;
    }

    .jumlah-preview.error span {
        color: var(--danger) !important;
        font-weight: 600;
    }

    /* ── Badge Opsional ── */
    .badge-opsional {
        background: #f1f5f9;
        color: #64748b;
        font-size: .68rem;
        font-weight: 600;
        padding: .2rem .55rem;
        border-radius: 99px;
        margin-left: .4rem;
        vertical-align: middle;
    }

    /* ── File Hint ── */
    .file-hint {
        font-size: .78rem;
        color: var(--text-muted);
        margin-top: .4rem;
    }
</style>
@endsection

@section('scripts')
<script>
    function hitungJumlahHari() {
        const tanggalMulai   = document.getElementById('tanggal_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;
        const preview        = document.getElementById('jumlah_preview');
        const text           = document.getElementById('jumlah_text');
        const hidden         = document.getElementById('jumlah_hari');

        if (tanggalMulai && tanggalSelesai) {
            const start = new Date(tanggalMulai);
            const end   = new Date(tanggalSelesai);

            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                text.textContent  = '🗓️  ' + diffDays + ' hari kerja diperlukan';
                hidden.value      = diffDays;
                preview.className = 'jumlah-preview aktif';
            } else {
                text.textContent  = '⚠️  Tanggal selesai tidak boleh sebelum tanggal mulai';
                hidden.value      = '';
                preview.className = 'jumlah-preview error';
            }
        } else {
            text.textContent  = 'Pilih tanggal mulai dan selesai terlebih dahulu';
            hidden.value      = '';
            preview.className = 'jumlah-preview';
        }
    }

    document.getElementById('tanggal_mulai').addEventListener('change', hitungJumlahHari);
    document.getElementById('tanggal_selesai').addEventListener('change', hitungJumlahHari);
</script>
@endsection