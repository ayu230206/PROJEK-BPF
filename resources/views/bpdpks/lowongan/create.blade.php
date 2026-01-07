@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Lowongan & Magang')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-plus-circle me-2"></i> Tambah Lowongan / Magang Baru
            </h1>
            <p class="text-sm opacity-85 mt-1">Masukkan detail lowongan kerja atau kesempatan magang untuk beasiswa.</p>
        </div>
    </div>

    {{-- ===================== PESAN ERROR VALIDASI (Menggunakan Kelas Bootstrap Asli) ===================== --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-xl border border-red-400" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===================== FORM TAMBAH LOWONGAN (Layout 2 Kolom) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100">
        <form action="{{ route('bpdpks.lowongan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {{-- ========== KOLOM KIRI: INFO DETAIL (col-md-6) ========== --}}
                <div class="col-md-6 border-e pe-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-info-circle text-green-700"></i> Informasi Dasar Lowongan</h3>

                    {{-- Tipe Iklan (Row 1) --}}
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Tipe Iklan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="tipe" name="tipe" required>
                                <option value="magang" {{ old('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                                <option value="lowongan_kerja" {{ old('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>
                                    Lowongan Kerja</option>
                            </select>
                            @error('tipe')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Deadline <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="deadline" name="deadline"
                                value="{{ old('deadline') }}" required>
                            @error('deadline')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
                            @error('lokasi')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Field Judul --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required>
                        @error('judul')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Field Gaji (Conditional) --}}
                    {{-- Style: Display diatur oleh JS di bawah --}}
                    <div class="mb-4" id="gajiField"
                        style="{{ old('tipe', 'magang') == 'lowongan_kerja' ? 'display:block;' : 'display:none;' }}">
                        <label class="form-label font-medium text-gray-700">Gaji (Opsional)</label>
                        <input type="text" class="form-control" name="gaji" value="{{ old('gaji') }}">
                        @error('gaji')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Field Magang (Conditional) --}}
                    {{-- Style: Display diatur oleh JS di bawah --}}
                    <div class="row" id="magangField"
                        style="{{ old('tipe', 'magang') == 'magang' ? 'display:flex;' : 'display:none;' }}">
                        <div class="col-md-6 mb-4">
                            <label class="form-label font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Kualifikasi --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Kualifikasi</label>
                        <textarea class="form-control" name="kualifikasi" rows="5">{{ old('kualifikasi') }}</textarea>
                        @error('kualifikasi')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                </div> {{-- Akhir Kolom Kiri --}}

                {{-- ========== KOLOM KANAN: UPLOAD FILES (col-md-6) ========== --}}
                <div class="col-md-6 ps-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-paperclip text-green-700"></i> Media & Dokumen</h3>

                    {{-- Foto Lowongan --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Foto Lowongan (opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="form-control">
                        <small class="text-muted">Format: JPG, PNG. Maksimal ukuran file: 2MB.</small>
                        @error('foto')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- File Pendukung --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">File Pendukung (PDF, opsional)</label>
                        <input type="file" name="file_pendukung" accept="application/pdf" class="form-control">
                        <small class="text-muted">Format: PDF saja. Maksimal ukuran file: 5MB.</small>
                        @error('file_pendukung')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>


                </div> {{-- Akhir Kolom Kanan --}}

            </div> {{-- Akhir Row Utama --}}

            <hr class="mt-4 mb-4">

            {{-- Tombol Aksi --}}
            <div class="flex space-x-3 justify-end">
                <button type="submit"
                    class="btn btn-primary bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white shadow-md transition duration-150">
                    <i class="fas fa-save me-1"></i> Simpan Lowongan
                </button>
                <a href="{{ route('bpdpks.lowongan.index') }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white shadow-md transition duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- ===================== LOGIKA JAVASCRIPT (TIDAK DIUBAH FUNGSINYA) ===================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Jalankan fungsi saat DOM dimuat untuk menyesuaikan tampilan berdasarkan old('tipe')
            let tipeSelect = document.getElementById('tipe');

            // Fungsi untuk mengontrol visibility
            function toggleFields() {
                let tipe = tipeSelect.value;
                document.getElementById('gajiField').style.display = (tipe === 'lowongan_kerja') ? 'block' : 'none';
                // Karena magangField adalah row, kita ubah dari 'none' ke 'flex' agar layoutnya benar
                document.getElementById('magangField').style.display = (tipe === 'magang') ? 'flex' : 'none';
            }

            // Panggil saat dimuat untuk inisialisasi awal (mempertimbangkan old('tipe'))
            toggleFields();

            // Tambahkan event listener untuk perubahan
            tipeSelect.addEventListener('change', toggleFields);
        });
    </script>

@endsection