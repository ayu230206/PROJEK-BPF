@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Lowongan & Magang')

@section('content')
    <div class="header">
        <h1 class="welcome"><i class="fas fa-plus me-2"></i> Tambah Lowongan / Magang Baru</h1>
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
        <form action="{{ route('bpdpks.lowongan.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipe" class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
                    <select class="form-control" id="tipe" name="tipe" required>
                        <option value="magang" {{ old('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                        <option value="lowongan_kerja" {{ old('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
                    </select>
                    @error('tipe')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deadline" class="form-label">Batas Akhir Pendaftaran</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline') }}">
                    @error('deadline')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Lowongan/Posisi <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan/Magang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="kualifikasi" class="form-label">Kualifikasi/Persyaratan</label>
                <textarea class="form-control" id="kualifikasi" name="kualifikasi" rows="5">{{ old('kualifikasi') }}</textarea>
                <small class="text-muted">Gunakan bullet point atau list untuk keterbacaan yang lebih baik.</small>
                @error('kualifikasi')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);"><i class="fas fa-save me-1"></i> Simpan Lowongan</button>
            <a href="{{ route('bpdpks.lowongan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection