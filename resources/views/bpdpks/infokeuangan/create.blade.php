@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Data Pencairan Beasiswa')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Warna Hijau Gelap Konsisten) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-plus-square me-2"></i> Tambah Data Pencairan
            </h1>
            <p class="text-sm opacity-85 mt-1">Masukkan data pencairan dana beasiswa untuk mahasiswa penerima.</p>
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

    {{-- ===================== FORM TAMBAH PENCAIRAN (Layout 2 Kolom, Upload di Kanan Bawah) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100">
        {{-- Tambahkan enctype="multipart/form-data" karena ada file upload --}}
        <form action="{{ route('bpdpks.keuangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ROW UTAMA (Detail Penerima, Jadwal, Dana, dan Catatan) --}}
            <div class="row">
                {{-- ========== KOLOM KIRI: DETAIL PENCARIAN & DANA (col-md-6) ========== --}}
                <div class="col-md-6 border-e pe-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detail Penerima & Jadwal</h3>

                    <div class="mb-4">
                        <label for="mahasiswa_id" class="form-label font-medium text-gray-700">Mahasiswa Penerima <span
                                class="text-red-500">*</span></label>
                        <select class="form-control" id="mahasiswa_id" name="mahasiswa_id" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            {{-- FUNGSIONALITAS DATABASE DIKEMBALIKAN --}}
                            {{-- Pastikan Controller mengirimkan variabel $mahasiswas --}}
                            @foreach ($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                    {{ $mhs->nama_lengkap }} (ID: {{ $mhs->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="semester" class="form-label font-medium text-gray-700">Semester Pencairan <span
                                class="text-red-500">*</span></label>
                        {{-- Input type dikembalikan ke text sesuai kode lama --}}
                        <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}"
                            placeholder="Contoh: Semester 5" required>
                        @error('semester')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_transfer" class="form-label font-medium text-gray-700">Tanggal Transfer</label>
                        <input type="date" class="form-control" id="tanggal_transfer" name="tanggal_transfer"
                            value="{{ old('tanggal_transfer') }}">
                        @error('tanggal_transfer')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="status_pencairan" class="form-label font-medium text-gray-700">Status Pencairan <span
                                class="text-red-500">*</span></label>
                        <select class="form-control" id="status_pencairan" name="status_pencairan" required>
                            {{-- Nilai opsi disesuaikan dengan kode lama (lowercase) --}}
                            <option value="proses" {{ old('status_pencairan') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="ditransfer" {{ old('status_pencairan') == 'ditransfer' ? 'selected' : '' }}>
                                Ditransfer</option>
                            <option value="diterima" {{ old('status_pencairan') == 'diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="ditangguhkan" {{ old('status_pencairan') == 'ditangguhkan' ? 'selected' : '' }}>
                                Ditangguhkan</option>
                        </select>
                        @error('status_pencairan')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 mt-5">Alokasi Dana</h3>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="jumlah_bulanan" class="form-label font-medium text-gray-700">Jumlah Bulanan (Rp)
                                <span class="text-red-500">*</span></label>
                            {{-- Input type dikembalikan ke number sesuai kode lama --}}
                            <input type="number" class="form-control" id="jumlah_bulanan" name="jumlah_bulanan"
                                value="{{ old('jumlah_bulanan') }}" required>
                            @error('jumlah_bulanan')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="jumlah_buku" class="form-label font-medium text-gray-700">Jumlah Buku (Rp)</label>
                            {{-- Input type dikembalikan ke number sesuai kode lama --}}
                            <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku"
                                value="{{ old('jumlah_buku') ?? 0 }}">
                            @error('jumlah_buku')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div> {{-- Akhir Kolom Kiri --}}

                {{-- ========== KOLOM KANAN: CATATAN TAMBAHAN & UPLOAD (col-md-6) ========== --}}
                <div class="col-md-6 ps-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Catatan Tambahan</h3>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label font-medium text-gray-700">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="5"
                            placeholder="Tambahkan informasi penting terkait pencairan ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-5">
                        <label for="alasan_ditangguhkan" class="form-label font-medium text-gray-700">Alasan Ditangguhkan
                            (Isi jika status = Ditangguhkan)</label>
                        <textarea class="form-control" id="alasan_ditangguhkan" name="alasan_ditangguhkan" rows="5"
                            placeholder="Jelaskan alasan penangguhan jika status = Ditangguhkan...">{{ old('alasan_ditangguhkan') }}</textarea>
                        @error('alasan_ditangguhkan')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- DOKUMENTASI/UPLOAD (DI KANAN BAWAH) --}}
                    <hr class="mb-4 mt-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dokumentasi Bukti Transfer</h3>

                    <div class="mb-4">
                        <label for="bukti_transfer" class="form-label font-medium text-gray-700">Bukti Transfer
                            (PDF/Gambar)</label>
                        {{-- Disesuaikan dengan kode lama, tidak wajib * --}}
                        <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer"
                            accept=".pdf, image/*">
                        <small class="text-gray-500 mt-1 d-block">Maks 5MB (PDF atau Gambar)</small>
                        @error('bukti_transfer')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                </div> {{-- Akhir Kolom Kanan --}}
            </div> {{-- Akhir Row Utama --}}

            <hr class="mb-4 mt-5">

            {{-- Tombol Aksi di Bawah Form --}}
            <div class="flex space-x-3 justify-end">
                <a href="{{ route('bpdpks.keuangan.index') }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white shadow-md transition duration-150">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="submit"
                    class="btn btn-primary bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white shadow-md transition duration-150">
                    <i class="fas fa-save me-1"></i> Simpan Data Pencairan
                </button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    {{-- Script untuk format mata uang atau Select2 dapat diletakkan di sini --}}
@endsection