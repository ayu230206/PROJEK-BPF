@extends('admin.layout.LayoutAdmin')

@section('title', 'Tambah Penelitian/Lomba Baru')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-plus-circle me-2"></i> Tambah Kegiatan</h1>
            <p class="subtle">Publikasikan informasi lomba atau penelitian baru.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.penelitian-lomba.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-custom">
        <form action="{{ route('admin.penelitian-lomba.store') }}" method="POST">
            @csrf
            
            <h5 class="section-title text-primary mb-4">Detail Kegiatan</h5>

            <div class="row g-4 mb-3">
                <div class="col-md-4">
                    <label for="tipe" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="penelitian" {{ old('tipe') == 'penelitian' ? 'selected' : '' }}>Penelitian / Riset</option>
                        <option value="lomba" {{ old('tipe') == 'lomba' ? 'selected' : '' }}>Lomba / Kompetisi</option>
                    </select>
                    @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-8">
                    <label for="judul" class="form-label fw-bold">Judul Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Lomba Esai Sawit Nasional 2025" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="penyelenggara" class="form-label fw-bold">Penyelenggara</label>
                <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" 
                       id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}" placeholder="Contoh: BPDPKS, Universitas X, dll.">
                @error('penyelenggara')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Lengkap</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="6" placeholder="Tuliskan detail, syarat, dan ketentuan kegiatan ini.">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.penelitian-lomba.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-5" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                    <i class="fas fa-save me-2"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
@endsection