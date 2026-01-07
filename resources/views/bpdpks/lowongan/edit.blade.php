@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Edit Lowongan & Magang')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-edit me-2"></i> Edit Lowongan / Magang
            </h1>
            <p class="text-sm opacity-85 mt-1">Perbarui detail lowongan kerja atau kesempatan magang.</p>
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

    {{-- ===================== FORM EDIT LOWONGAN (Layout 2 Kolom) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100">
        <form action="{{ route('bpdpks.lowongan.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- ========== KOLOM KIRI: INFO DETAIL (col-md-6) ========== --}}
                <div class="col-md-6 border-e pe-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-info-circle text-green-700"></i> Informasi Dasar Lowongan</h3>

                    {{-- Tipe Iklan, Deadline, Lokasi (Disusun dalam satu row) --}}
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Tipe Iklan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="tipe" name="tipe">
                                {{-- Logic tidak diubah --}}
                                <option value="magang" {{ $lowongan->tipe == 'magang' ? 'selected' : '' }}>Magang</option>
                                <option value="lowongan_kerja" {{ $lowongan->tipe == 'lowongan_kerja' ? 'selected' : '' }}>
                                    Lowongan Kerja</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Deadline</label>
                            {{-- Logic tidak diubah --}}
                            <input type="date" class="form-control" id="deadline" name="deadline"
                                value="{{ $lowongan->deadline }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label font-medium text-gray-700">Lokasi</label>
                            {{-- Logic tidak diubah --}}
                            <input type="text" class="form-control" name="lokasi" value="{{ $lowongan->lokasi }}">
                        </div>
                    </div>

                    {{-- Field Gaji (Conditional) --}}
                    @if($lowongan->tipe == 'lowongan_kerja')
                        <div class="mb-4" id="gajiField">
                            <label class="form-label font-medium text-gray-700">Gaji</label>
                            <input type="text" class="form-control" name="gaji" value="{{ $lowongan->gaji }}">
                        </div>
                    @endif

                    {{-- Field Magang (Conditional) --}}
                    @if($lowongan->tipe == 'magang')
                        <div class="row" id="magangField">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-medium text-gray-700">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai"
                                    value="{{ $lowongan->tanggal_mulai }}">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-medium text-gray-700">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai"
                                    value="{{ $lowongan->tanggal_selesai }}">
                            </div>
                        </div>
                    @endif

                    <hr class="my-4">

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Judul</label>
                        <input type="text" class="form-control" name="judul" value="{{ $lowongan->judul }}" required>
                    </div>

                    {{-- Deskripsi (Dibiarkan panjang di kolom kiri) --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="5">{{ $lowongan->deskripsi }}</textarea>
                    </div>

                    {{-- Kualifikasi (Dibiarkan panjang di kolom kiri) --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Kualifikasi</label>
                        <textarea class="form-control" name="kualifikasi" rows="5">{{ $lowongan->kualifikasi }}</textarea>
                    </div>

                </div> {{-- Akhir Kolom Kiri --}}

                {{-- ========== KOLOM KANAN: UPLOAD FILES (col-md-6) ========== --}}
                <div class="col-md-6 ps-md-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2"><i
                            class="fas fa-paperclip text-green-700"></i> Media & Dokumen</h3>

                    {{-- Foto Lowongan --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">Foto Lowongan (opsional)</label>
                        @if($lowongan->foto)
                            <div class="mb-2 p-2 border rounded bg-gray-50">
                                <p class="text-sm font-medium mb-1">File saat ini:</p>
                                <img src="{{ asset('storage/' . $lowongan->foto) }}" alt="Foto Lowongan" class="img-thumbnail"
                                    width="150">
                            </div>
                        @endif
                        <input type="file" name="foto" accept="image/*" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    {{-- File Pendukung --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-700">File Pendukung (PDF, opsional)</label>
                        @if($lowongan->file_pendukung)
                            <div class="mb-2 p-2 border rounded bg-gray-50">
                                <p class="text-sm font-medium mb-1">File saat ini:</p>
                                <a href="{{ asset('storage/' . $lowongan->file_pendukung) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800"><i class="fas fa-file-pdf me-1"></i> Lihat File
                                    Pendukung</a>
                            </div>
                        @endif
                        <input type="file" name="file_pendukung" accept="application/pdf" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                    </div>

                </div> {{-- Akhir Kolom Kanan --}}

            </div> {{-- Akhir Row Utama --}}

            <hr class="mt-4 mb-4">

            {{-- Tombol Aksi (Di kanan bawah) --}}
            <div class="flex space-x-3 justify-end">
                {{-- Tombol Update diubah ke warna hijau konsisten --}}
                <button type="submit"
                    class="btn btn-primary bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white shadow-md transition duration-150">
                    <i class="fas fa-save me-1"></i> Perbarui Data
                </button>
                {{-- Tombol Batal --}}
                <a href="{{ route('bpdpks.lowongan.index') }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white shadow-md transition duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        // Logika ini tetap dipertahankan
        document.getElementById('tipe').addEventListener('change', function () {
            location.reload(); // field menyesuaikan otomatis
        });
    </script>

@endsection