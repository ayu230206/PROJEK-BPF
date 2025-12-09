@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="header">
        <h1 class="welcome"><i class="fas fa-edit me-2"></i> Edit Lowongan / Magang</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-custom">
        <form action="{{ route('admin.lowongan.update', $lowongan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipe" class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
                    <select class="form-control" id="tipe" name="tipe" required>
                        <option value="magang" {{ old('tipe', $lowongan->tipe) == 'magang' ? 'selected' : '' }}>Magang</option>
                        <option value="lowongan_kerja" {{ old('tipe', $lowongan->tipe) == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
                    </select>
                    @error('tipe')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deadline" class="form-label">Batas Akhir Pendaftaran</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline', $lowongan->deadline) }}">
                    @error('deadline')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Lowongan/Posisi <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $lowongan->judul) }}" required>
                @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan/Magang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                @error('deskripsi')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="kualifikasi" class="form-label">Kualifikasi/Persyaratan</label>
                <textarea class="form-control" id="kualifikasi" name="kualifikasi" rows="5">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                <small class="text-muted">Gunakan bullet point atau list untuk keterbacaan yang lebih baik.</small>
                @error('kualifikasi')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);"><i class="fas fa-save me-1"></i> Perbarui Lowongan</button>
            <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection