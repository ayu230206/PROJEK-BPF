@extends('admin.layout.LayoutAdmin')

@section('title', 'Tambah Kampus Mitra')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-plus-circle me-2"></i> Tambah Kampus</h1>
            <p class="subtle">Tambahkan mitra universitas baru untuk program beasiswa.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.kampus.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-custom">
        <form action="{{ route('admin.kampus.store') }}" method="POST">
            @csrf
            
            <h5 class="section-title text-primary mb-4">Profil Kampus</h5>

            <div class="row g-4">
                <div class="col-md-8">
                    <label for="nama_kampus" class="form-label fw-bold">Nama Kampus <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kampus" id="nama_kampus" class="form-control form-control-lg" placeholder="Contoh: Institut Pertanian Bogor" required>
                </div>
                <div class="col-md-4">
                    <label for="kode_kampus" class="form-label fw-bold">Kode Kampus</label>
                    <input type="text" name="kode_kampus" id="kode_kampus" class="form-control form-control-lg" placeholder="Contoh: IPB">
                    <small class="text-muted">Singkatan atau kode unik kampus.</small>
                </div>
            </div>

            <h5 class="section-title text-primary mb-4 mt-5">Status Kerjasama</h5>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="status_kerjasama" class="form-label fw-bold">Status MoU</label>
                    <select name="status_kerjasama" id="status_kerjasama" class="form-select form-select-lg">
                        <option value="aktif">Aktif</option>
                        <option value="pending">Pending (Menunggu Persetujuan)</option>
                        <option value="nonaktif">Non-Aktif</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.kampus.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-5" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                    <i class="fas fa-save me-2"></i> Simpan Kampus
                </button>
            </div>
        </form>
    </div>
@endsection