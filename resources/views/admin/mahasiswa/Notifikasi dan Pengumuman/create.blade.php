@extends('admin.layout.LayoutAdmin')

@section('title', 'Buat Pengumuman Baru')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Formulir Pengumuman ke Mahasiswa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.notifikasi.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="judul" class="form-label">Judul/Subjek Pengumuman</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi_pesan" class="form-label">Isi Pesan/Detail Notifikasi</label>
                <textarea class="form-control @error('isi_pesan') is-invalid @enderror" id="isi_pesan" name="isi_pesan" rows="5" required>{{ old('isi_pesan') }}</textarea>
                @error('isi_pesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Notifikasi (Optional)</label>
                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                    <option value="umum">Umum</option>
                    <option value="pencairan">Pencairan Dana</option>
                    <option value="registrasi_ulang">Registrasi Ulang</option>
                </select>
                @error('jenis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Pengumuman</button>
            </div>
        </form>
    </div>
</div>
@endsection