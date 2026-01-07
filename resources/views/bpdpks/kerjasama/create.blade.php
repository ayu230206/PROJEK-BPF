@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Kampus')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Struktur dan Kelas Tailwind) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-plus-circle me-2"></i> Tambah Data Kampus Baru
            </h1>
            <p class="text-sm opacity-85 mt-1">Masukkan informasi lengkap mengenai kampus mitra baru.</p>
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

    {{-- ===================== FORM TAMBAH KAMPUS (Layout 2 Kolom) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100">
        <form action="{{ route('bpdpks.kerjasama.store') }}" method="POST">
            @csrf

            {{-- ROW UTAMA: GRID DUA KOLOM --}}
            <div class="row">

                {{-- ========== KOLOM KIRI: INFO DASAR & MOU (col-md-6) ========== --}}
                <div class="col-md-6 border-e pe-md-4">

                    {{-- Group 1: Informasi Dasar --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-university text-green-700"></i> Informasi Dasar</h3>

                    <div class="mb-4">
                        <label for="nama_kampus" class="form-label font-medium text-gray-700">Nama Kampus <span
                                class="text-red-500">*</span></label>
                        <input type="text" class="form-control" id="nama_kampus" name="nama_kampus"
                            value="{{ old('nama_kampus') }}" required>
                        @error('nama_kampus')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-5">
                        <label for="kode_kampus" class="form-label font-medium text-gray-700">Kode Kampus
                            (Singkatan)</label>
                        <input type="text" class="form-control" id="kode_kampus" name="kode_kampus"
                            value="{{ old('kode_kampus') }}">
                        @error('kode_kampus')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <hr class="mt-5 mb-4">

                    {{-- Group 2: Detail MoU --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-file-signature text-green-700"></i> Detail MoU Kerjasama</h3>

                    <div class="mb-4">
                        <label for="nomor_mou" class="form-label font-medium text-gray-700">Nomor MoU Kerjasama</label>
                        <input type="text" class="form-control" id="nomor_mou" name="nomor_mou"
                            value="{{ old('nomor_mou') }}">
                        @error('nomor_mou')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_mou" class="form-label font-medium text-gray-700">Tanggal MoU</label>
                        <input type="date" class="form-control" id="tanggal_mou" name="tanggal_mou"
                            value="{{ old('tanggal_mou') }}">
                        @error('tanggal_mou')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                </div> {{-- Akhir Kolom Kiri --}}

                {{-- ========== KOLOM KANAN: ALAMAT & STATUS (col-md-6) ========== --}}
                <div class="col-md-6 ps-md-4">

                    {{-- Group 3: Alamat --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-map-marked-alt text-green-700"></i> Lokasi & Kontak</h3>

                    <div class="mb-5">
                        <label for="alamat" class="form-label font-medium text-gray-700">Alamat Kampus</label>
                        {{-- Menggunakan rows 6 agar lebih panjang dan sejajar dengan kolom kiri --}}
                        <textarea class="form-control" id="alamat" name="alamat" rows="6">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-5">

                    {{-- Group 4: Status --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-check-circle text-green-700"></i> Status Kerjasama</h3>

                    <div class="mb-4">
                        <label for="status_aktif" class="form-label font-medium text-gray-700">Status Kerjasama <span
                                class="text-red-500">*</span></label>
                        <select class="form-control" id="status_aktif" name="status_aktif" required>
                            {{-- Nilai 1 (Aktif) dan 0 (Nonaktif) --}}
                            <option value="1" {{ old('status_aktif', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status_aktif')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                </div> {{-- Akhir Kolom Kanan --}}
            </div> {{-- Akhir Row Utama --}}

            <hr class="mt-6 mb-4">

            {{-- Tombol Aksi (Di luar kolom) --}}
            <div class="flex space-x-3 justify-end">
                {{-- Tombol utama menggunakan warna hijau --}}
                <button type="submit"
                    class="btn btn-primary bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white shadow-md transition duration-150">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
                <a href="{{ route('bpdpks.kerjasama.index') }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white shadow-md transition duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection