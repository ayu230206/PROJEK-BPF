@extends('admin.layout.LayoutAdmin')

@section('title', 'Tambah Lowongan Baru')

@section('content')
<div class="container-fluid px-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div>
            <h1 class="display-5 fw-bold text-dark">
                <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Lowongan
            </h1>
            <p class="text-muted fs-5 mb-0">Buat lowongan kerja atau magang baru untuk mahasiswa.</p>
        </div>
        <a href="{{ route('admin.lowongan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Terjadi Kesalahan!</h5>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Formulir Data</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.lowongan.store') }}" method="POST">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label for="judul" class="form-label fw-semibold">Judul Posisi / Lowongan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-briefcase text-muted"></i></span>
                            <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}" 
                                   placeholder="Contoh: Staff IT Support atau Magang Web Developer" required>
                        </div>
                        @error('judul')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tipe" class="form-label fw-semibold">Tipe Program <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-tag text-muted"></i></span>
                            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                                <option value="" disabled selected>-- Pilih Tipe --</option>
                                <option value="magang" {{ old('tipe') == 'magang' ? 'selected' : '' }}>Magang Mahasiswa</option>
                                <option value="lowongan_kerja" {{ old('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja (Full Time)</option>
                            </select>
                        </div>
                        @error('tipe')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="deadline" class="form-label fw-semibold">Batas Akhir Pendaftaran</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                   id="deadline" name="deadline" value="{{ old('deadline') }}">
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ada batas waktu tertentu.</small>
                        @error('deadline')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="deskripsi" class="form-label fw-semibold">
                            <i class="fas fa-align-left me-1 text-primary"></i> Deskripsi Pekerjaan
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="8" 
                                  placeholder="Jelaskan tanggung jawab dan gambaran pekerjaan...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="kualifikasi" class="form-label fw-semibold">
                            <i class="fas fa-check-double me-1 text-primary"></i> Kualifikasi / Syarat
                        </label>
                        <div class="bg-light p-3 rounded mb-2 border">
                            <small class="text-muted d-block mb-1"><i class="fas fa-lightbulb text-warning me-1"></i> <strong>Tips:</strong> Gunakan tanda (-) untuk membuat list agar rapi.</small>
                        </div>
                        <textarea class="form-control @error('kualifikasi') is-invalid @enderror" 
                                  id="kualifikasi" name="kualifikasi" rows="6" 
                                  placeholder="- Mahasiswa semester akhir&#10;- Menguasai PHP&#10;- Mampu bekerja tim">{{ old('kualifikasi') }}</textarea>
                        @error('kualifikasi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ route('admin.lowongan.index') }}" class="btn btn-light border btn-lg px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" style="background-color: var(--primary); border-color: var(--primary);">
                        <i class="fas fa-save me-2"></i> Simpan & Terbitkan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT TAMBAHAN UNTUK UX --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Set Min Date ke Hari Ini (Agar tidak bisa pilih tanggal kemarin)
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("deadline").setAttribute('min', today);
    });
</script>

@endsection