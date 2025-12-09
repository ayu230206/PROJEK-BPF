@extends('admin.layout.LayoutAdmin')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-cog me-2"></i> Pengaturan Website</h1>
            <p class="subtle">Sesuaikan tampilan dan konfigurasi sistem Beasiswa Sawit.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-custom">
                <h5 class="section-title text-primary"><i class="fas fa-image me-2"></i> Identitas Visual</h5>
                
                <div class="row align-items-center mb-4 mt-4">
                    {{-- Kolom Kiri: Preview Logo --}}
                    <div class="col-md-5 text-center border-end">
                        <label class="form-label fw-bold text-muted mb-3">LOGO SAAT INI</label>
                        <div class="p-4 rounded bg-light border d-flex justify-content-center align-items-center" style="min-height: 180px;">
                            <img src="{{ asset($logoPath) }}?v={{ time() }}" alt="Website Logo" class="img-fluid" style="max-height: 120px;">
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Upload --}}
                    <div class="col-md-7 ps-md-4">
                        <form action="{{ route('admin.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="logo" class="form-label fw-bold">Unggah Logo Baru</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg" required>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format: PNG, JPG (Transparan disarankan). Maks: 2MB.
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary shadow-sm" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan Logo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">
                
                <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info">
                    <div class="d-flex">
                        <i class="fas fa-lightbulb me-3 mt-1 fs-5"></i>
                        <div>
                            <strong>Info Pengembang:</strong><br>
                            Pengaturan lainnya seperti Judul Website, Meta Description, dan Kontak Admin dapat ditambahkan di bagian ini sesuai kebutuhan pengembangan selanjutnya.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection