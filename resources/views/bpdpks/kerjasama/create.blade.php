@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Kampus')

@section('content')
    <div class="header">
        <h1 class="welcome"><i class="fas fa-plus-circle me-2"></i> Tambah Data Kampus Baru</h1>
        <p class="subtle">Masukkan informasi lengkap mengenai kampus mitra baru.</p>
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
        <form action="{{ route('bpdpks.kerjasama.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_kampus" class="form-label">Nama Kampus <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_kampus" name="nama_kampus" value="{{ old('nama_kampus') }}" required>
                    @error('nama_kampus')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kode_kampus" class="form-label">Kode Kampus (Singkatan)</label>
                    <input type="text" class="form-control" id="kode_kampus" name="kode_kampus" value="{{ old('kode_kampus') }}">
                    @error('kode_kampus')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nomor_mou" class="form-label">Nomor MoU Kerjasama</label>
                    <input type="text" class="form-control" id="nomor_mou" name="nomor_mou" value="{{ old('nomor_mou') }}">
                    @error('nomor_mou')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mou" class="form-label">Tanggal MoU</label>
                    <input type="date" class="form-control" id="tanggal_mou" name="tanggal_mou" value="{{ old('tanggal_mou') }}">
                    @error('tanggal_mou')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Kampus</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="status_aktif" class="form-label">Status Kerjasama <span class="text-danger">*</span></label>
                <select class="form-control" id="status_aktif" name="status_aktif" required>
                    <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status_aktif')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);"><i class="fas fa-save me-1"></i> Simpan Data</button>
            <a href="{{ route('bpdpks.kerjasama.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection