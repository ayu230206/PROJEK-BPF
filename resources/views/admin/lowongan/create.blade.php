@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="header">
    <h1 class="welcome"><i class="fas fa-plus me-2"></i> Tambah Lowongan / Magang Baru</h1>
</div>

<div class="card-custom">
    {{-- WAJIB: enctype="multipart/form-data" untuk upload file --}}
    <form action="{{ route('admin.lowongan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
                <select class="form-control" name="tipe" required>
                    <option value="magang">Magang</option>
                    <option value="lowongan_kerja">Lowongan Kerja</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Batas Akhir Pendaftaran</label>
                <input type="date" class="form-control" name="deadline" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Lowongan/Posisi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="judul" placeholder="Contoh: Staff IT / Magang Web Dev" required>
        </div>

        {{-- Input Upload Gambar/Dokumen --}}
        <div class="mb-3">
            <label class="form-label fw-bold text-primary">Upload Banner / Poster / Dokumen (Opsional)</label>
            <input type="file" class="form-control" name="file_pendukung" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 2MB. File akan tersimpan di public/uploads.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Pekerjaan</label>
            <textarea class="form-control" name="deskripsi" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kualifikasi/Persyaratan</label>
            <textarea class="form-control" name="kualifikasi" rows="5"></textarea>
        </div>

        <hr>
        
        {{-- TOMBOL KIRIM YANG DIPERBAIKI --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary px-4 fw-bold">
                <i class="fas fa-paper-plane me-2"></i> KIRIM & TERBITKAN
            </button>
        </div>
    </form>
</div>
@endsection
