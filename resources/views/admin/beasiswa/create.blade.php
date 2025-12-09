@extends('admin.layout.LayoutAdmin')

@section('title', 'Buat Program Beasiswa Baru')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-plus-circle me-2"></i> Buat Program Baru</h1>
            <p class="subtle">Tambahkan informasi program beasiswa untuk periode baru.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-custom">
        <form action="{{ route('admin.beasiswa.store') }}" method="POST">
            @csrf
            
            <h5 class="section-title text-primary mb-4">Informasi Dasar</h5>

            <div class="mb-4">
                <label for="judul" class="form-label fw-bold">Judul Program <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-heading text-muted"></i></span>
                    <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" 
                           placeholder="Contoh: Beasiswa Sawit Indonesia 2025" required>
                </div>
                @error('judul')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="tanggal_mulai" class="form-label fw-bold">Tanggal Mulai Pendaftaran</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-calendar-check text-success"></i></span>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                               id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                    </div>
                    @error('tanggal_mulai')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_berakhir" class="form-label fw-bold">Tanggal Berakhir Pendaftaran</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-calendar-times text-danger"></i></span>
                        <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" 
                               id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                    </div>
                    @error('tanggal_berakhir')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <h5 class="section-title text-primary mb-4 mt-5">Detail Lengkap</h5>

            <div class="mb-4">
                <label for="isi_informasi" class="form-label fw-bold">Deskripsi & Syarat <span class="text-danger">*</span></label>
                <div class="bg-light p-3 rounded mb-2 border">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Tuliskan rincian persyaratan, cakupan beasiswa, dan cara mendaftar.</small>
                </div>
                <textarea class="form-control @error('isi_informasi') is-invalid @enderror" 
                          id="isi_informasi" name="isi_informasi" rows="8" required>{{ old('isi_informasi') }}</textarea>
                @error('isi_informasi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-5" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                    <i class="fas fa-save me-2"></i> Simpan Program
                </button>
            </div>
        </form>
    </div>
@endsection