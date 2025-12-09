@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Edit Data Keuangan')

@section('content')
    <div class="header">
        <h1 class="welcome"><i class="fas fa-edit me-2"></i> Edit Data Pencairan</h1>
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
        {{-- UBAH: Action mengarah ke route update dengan method PUT --}}
        <form action="{{ route('bpdpks.keuangan.update', $keuangan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- PENTING: Untuk menjalankan fungsi update di Controller --}}

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa Penerima <span class="text-danger">*</span></label>
                    <select class="form-control" id="mahasiswa_id" name="mahasiswa_id" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        {{-- UBAH: Set selected berdasarkan data lama/old input --}}
                        @foreach ($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}" {{ (old('mahasiswa_id', $keuangan->mahasiswa_id) == $mhs->id) ? 'selected' : '' }}>
                                {{ $mhs->nama_lengkap }} (ID: {{ $mhs->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="semester" class="form-label">Semester Pencairan <span class="text-danger">*</span></label>
                    {{-- UBAH: Isi dengan data lama --}}
                    <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester', $keuangan->semester) }}" placeholder="Contoh: Semester 5" required>
                    @error('semester')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_transfer" class="form-label">Tanggal Transfer</label>
                    {{-- UBAH: Isi dengan data lama --}}
                    <input type="date" class="form-control" id="tanggal_transfer" name="tanggal_transfer" value="{{ old('tanggal_transfer', $keuangan->tanggal_transfer) }}">
                    @error('tanggal_transfer')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status_pencairan" class="form-label">Status Pencairan <span class="text-danger">*</span></label>
                    <select class="form-control" id="status_pencairan" name="status_pencairan" required>
                        {{-- UBAH: Set selected berdasarkan data lama/old input --}}
                        <option value="proses" {{ old('status_pencairan', $keuangan->status_pencairan) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="ditransfer" {{ old('status_pencairan', $keuangan->status_pencairan) == 'ditransfer' ? 'selected' : '' }}>Ditransfer</option>
                        <option value="diterima" {{ old('status_pencairan', $keuangan->status_pencairan) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditangguhkan" {{ old('status_pencairan', $keuangan->status_pencairan) == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                    </select>
                    @error('status_pencairan')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jumlah_bulanan" class="form-label">Jumlah Bulanan (Rp) <span class="text-danger">*</span></label>
                    {{-- UBAH: Isi dengan data lama --}}
                    <input type="number" class="form-control" id="jumlah_bulanan" name="jumlah_bulanan" value="{{ old('jumlah_bulanan', $keuangan->jumlah_bulanan) }}" required>
                    @error('jumlah_bulanan')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jumlah_buku" class="form-label">Jumlah Buku (Rp)</label>
                    {{-- UBAH: Isi dengan data lama --}}
                    <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku" value="{{ old('jumlah_buku', $keuangan->jumlah_buku) }}">
                    @error('jumlah_buku')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="current_bukti" class="form-label">Bukti Transfer Saat Ini</label>
                @if ($keuangan->path_bukti_transfer)
                    <p>
                        {{-- Menggunakan Storage Facade untuk URL publik --}}
                        <a href="{{ Storage::url($keuangan->path_bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye me-1"></i> Lihat Bukti Lama
                        </a>
                        <span class="text-muted ms-3">Kosongkan jika tidak ingin mengganti.</span>
                    </p>
                @else
                    <p class="text-muted">Belum ada bukti transfer yang diunggah.</p>
                @endif
                <label for="bukti_transfer" class="form-label">Upload Bukti Baru (PDF/Gambar)</label>
                <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
                @error('bukti_transfer')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                {{-- UBAH: Isi dengan data lama --}}
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="alasan_ditangguhkan" class="form-label">Alasan Ditangguhkan (Isi jika status = Ditangguhkan)</label>
                {{-- UBAH: Isi dengan data lama --}}
                <textarea class="form-control" id="alasan_ditangguhkan" name="alasan_ditangguhkan" rows="2">{{ old('alasan_ditangguhkan', $keuangan->alasan_ditangguhkan) }}</textarea>
                @error('alasan_ditangguhkan')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);"><i class="fas fa-save me-1"></i> Perbarui Data</button>
            <a href="{{ route('bpdpks.keuangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection