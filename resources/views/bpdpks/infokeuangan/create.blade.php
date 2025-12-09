@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Data Keuangan')

@section('content')
    <div class="header">
        <h1 class="welcome"><i class="fas fa-plus me-2"></i> Tambah Data Pencairan</h1>
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
        <form action="{{ route('bpdpks.keuangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa Penerima <span class="text-danger">*</span></label>
                    <select class="form-control" id="mahasiswa_id" name="mahasiswa_id" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach ($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nama_lengkap }} (ID: {{ $mhs->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="semester" class="form-label">Semester Pencairan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}" placeholder="Contoh: Semester 5" required>
                    @error('semester')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_transfer" class="form-label">Tanggal Transfer</label>
                    <input type="date" class="form-control" id="tanggal_transfer" name="tanggal_transfer" value="{{ old('tanggal_transfer') }}">
                    @error('tanggal_transfer')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status_pencairan" class="form-label">Status Pencairan <span class="text-danger">*</span></label>
                    <select class="form-control" id="status_pencairan" name="status_pencairan" required>
                        <option value="proses" {{ old('status_pencairan') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="ditransfer" {{ old('status_pencairan') == 'ditransfer' ? 'selected' : '' }}>Ditransfer</option>
                        <option value="diterima" {{ old('status_pencairan') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditangguhkan" {{ old('status_pencairan') == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                    </select>
                    @error('status_pencairan')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jumlah_bulanan" class="form-label">Jumlah Bulanan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="jumlah_bulanan" name="jumlah_bulanan" value="{{ old('jumlah_bulanan') }}" required>
                    @error('jumlah_bulanan')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jumlah_buku" class="form-label">Jumlah Buku (Rp)</label>
                    <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku" value="{{ old('jumlah_buku') ?? 0 }}">
                    @error('jumlah_buku')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="bukti_transfer" class="form-label">Bukti Transfer (PDF/Gambar)</label>
                <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
                @error('bukti_transfer')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="alasan_ditangguhkan" class="form-label">Alasan Ditangguhkan (Isi jika status = Ditangguhkan)</label>
                <textarea class="form-control" id="alasan_ditangguhkan" name="alasan_ditangguhkan" rows="2">{{ old('alasan_ditangguhkan') }}</textarea>
                @error('alasan_ditangguhkan')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);"><i class="fas fa-save me-1"></i> Simpan Data</button>
            <a href="{{ route('bpdpks.keuangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection