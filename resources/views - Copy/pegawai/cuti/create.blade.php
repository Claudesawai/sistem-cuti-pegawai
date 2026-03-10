@extends('layouts.app')

@section('title', 'Ajukan Cuti')
@section('page-title', 'Ajukan Cuti')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Form Pengajuan Cuti
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Sisa Cuti Tahunan Anda:</strong> {{ $user->sisa_cuti }} hari
                </div>

                <form action="{{ route('pegawai.cuti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="jenis_cuti" class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_cuti') is-invalid @enderror" 
                                id="jenis_cuti" name="jenis_cuti" required>
                            <option value="">Pilih Jenis Cuti</option>
                            <option value="cuti_tahunan" {{ old('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>
                                Cuti Tahunan (Sisa: {{ $user->sisa_cuti }} hari)
                            </option>
                            <option value="cuti_sakit" {{ old('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>
                                Cuti Sakit
                            </option>
                            <option value="izin" {{ old('jenis_cuti') == 'izin' ? 'selected' : '' }}>
                                Izin
                            </option>
                        </select>
                        @error('jenis_cuti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai') }}" required
                                   min="{{ date('Y-m-d') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai') }}" required
                                   min="{{ date('Y-m-d') }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_hari" class="form-label">Jumlah Hari</label>
                        <input type="text" class="form-control" id="jumlah_hari" readonly 
                               value="{{ old('jumlah_hari') ? old('jumlah_hari') . ' hari' : '-' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Cuti <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan') is-invalid @enderror" 
                                  id="alasan" name="alasan" rows="4" required
                                  placeholder="Jelaskan alasan cuti Anda...">{{ old('alasan') }}</textarea>
                        @error('alasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="file_pendukung" class="form-label">File Pendukung (Opsional)</label>
                        <input type="file" class="form-control @error('file_pendukung') is-invalid @enderror" 
                               id="file_pendukung" name="file_pendukung"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Format: PDF, JPG, JPEG, PNG. Maksimal 2MB.
                        </small>
                        @error('file_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Ajukan Cuti
                        </button>
                        <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function hitungJumlahHari() {
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;
        
        if (tanggalMulai && tanggalSelesai) {
            const start = new Date(tanggalMulai);
            const end = new Date(tanggalSelesai);
            
            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('jumlah_hari').value = diffDays + ' hari';
            } else {
                document.getElementById('jumlah_hari').value = 'Tanggal tidak valid';
            }
        }
    }
    
    document.getElementById('tanggal_mulai').addEventListener('change', hitungJumlahHari);
    document.getElementById('tanggal_selesai').addEventListener('change', hitungJumlahHari);
</script>
@endsection
@endsection
