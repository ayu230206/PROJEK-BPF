@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Edit Data Keuangan')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Warna Hijau Gelap Konsisten) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-edit me-2"></i> Edit Data Pencairan
            </h1>
            <p class="text-sm opacity-85 mt-1">Kelola dan perbarui detail pencairan dana beasiswa untuk mahasiswa penerima.
            </p>
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

    {{-- ===================== FORM CARD DENGAN DUA KOLOM UTAMA (Layout Grid Tailwind) ===================== --}}
    <div class="bg-white p-6 md:p-10 shadow-xl rounded-2xl border border-gray-100">

        <form action="{{ route('bpdpks.keuangan.update', $keuangan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- CONTAINER UTAMA: GRID DUA KOLOM (md:grid-cols-2) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12">

                {{-- KOLOM KIRI (1): Detail Penerima, Jadwal, dan Alokasi Dana --}}
                <div class="border-b md:border-b-0 md:border-r border-gray-200 md:pr-6 pb-6 md:pb-0">

                    {{-- KELOMPOK 1: Detail Penerima & Jadwal --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center gap-2"><i
                                class="fas fa-user-check text-green-700"></i> Detail Penerima & Jadwal</h3>

                        <div class="space-y-4">
                            <label for="mahasiswa_id" class="block text-sm font-semibold text-gray-700 mb-2">Mahasiswa
                                Penerima <span class="text-red-500">*</span></label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <select
                                class="form-select w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="mahasiswa_id" name="mahasiswa_id" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach ($mahasiswas as $mhs)
                                    <option value="{{ $mhs->id }}" {{ (old('mahasiswa_id', $keuangan->mahasiswa_id) == $mhs->id) ? 'selected' : '' }}>
                                        {{ $mhs->nama_lengkap }} (ID: {{ $mhs->id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-4 mt-4">
                            <label for="semester" class="block text-sm font-semibold text-gray-700 mb-2">Semester Pencairan
                                <span class="text-red-500">*</span></label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <input type="text"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="semester" name="semester" value="{{ old('semester', $keuangan->semester) }}"
                                placeholder="Contoh: Semester 5" required>
                            @error('semester')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-4 mt-4">
                            <label for="tanggal_transfer" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal
                                Transfer</label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <input type="date"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="tanggal_transfer" name="tanggal_transfer"
                                value="{{ old('tanggal_transfer', $keuangan->tanggal_transfer) }}">
                            @error('tanggal_transfer')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-4 mt-4">
                            <label for="status_pencairan" class="block text-sm font-semibold text-gray-700 mb-2">Status
                                Pencairan <span class="text-red-500">*</span></label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <select
                                class="form-select w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="status_pencairan" name="status_pencairan" required>
                                <option value="proses" {{ old('status_pencairan', $keuangan->status_pencairan) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="ditransfer" {{ old('status_pencairan', $keuangan->status_pencairan) == 'ditransfer' ? 'selected' : '' }}>Ditransfer</option>
                                <option value="diterima" {{ old('status_pencairan', $keuangan->status_pencairan) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditangguhkan" {{ old('status_pencairan', $keuangan->status_pencairan) == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                            </select>
                            @error('status_pencairan')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- KELOMPOK 2: Alokasi Dana --}}
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center gap-2"><i
                                class="fas fa-money-bill-wave text-green-700"></i> Alokasi Dana</h3>

                        <div class="space-y-4">
                            <label for="jumlah_bulanan" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah
                                Bulanan (Rp) <span class="text-red-500">*</span></label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <input type="number"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="jumlah_bulanan" name="jumlah_bulanan"
                                value="{{ old('jumlah_bulanan', $keuangan->jumlah_bulanan) }}" required>
                            @error('jumlah_bulanan')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-4 mt-4">
                            <label for="jumlah_buku" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Buku
                                (Rp)</label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <input type="number"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                id="jumlah_buku" name="jumlah_buku"
                                value="{{ old('jumlah_buku', $keuangan->jumlah_buku) }}">
                            @error('jumlah_buku')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (2): Catatan & Bukti Transfer --}}
                <div class="md:pl-6 pt-6 md:pt-0">

                    {{-- KELOMPOK 3: Keterangan dan Alasan --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center gap-2"><i
                                class="fas fa-clipboard-list text-green-700"></i> Catatan Tambahan</h3>

                        <div class="space-y-4">
                            <label for="keterangan"
                                class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <textarea
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                id="keterangan" name="keterangan" rows="6"
                                placeholder="Tambahkan informasi penting terkait pencairan ini...">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                            @error('keterangan')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-4 mt-4">
                            <label for="alasan_ditangguhkan" class="block text-sm font-semibold text-gray-700 mb-2">Alasan
                                Ditangguhkan <span class="text-gray-400">(Opsional)</span></label>
                            {{-- Focus Ring/Border diubah ke hijau --}}
                            <textarea
                                class="w-full border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                id="alasan_ditangguhkan" name="alasan_ditangguhkan" rows="4"
                                placeholder="Jelaskan alasan penangguhan jika status = Ditangguhkan... ">{{ old('alasan_ditangguhkan', $keuangan->alasan_ditangguhkan) }}</textarea>
                            @error('alasan_ditangguhkan')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- KELOMPOK 4: Bukti Transfer --}}
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center gap-2"><i
                                class="fas fa-file-upload text-green-700"></i> Dokumentasi Bukti Transfer</h3>

                        <div class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-300 shadow-inner">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm font-medium text-gray-700">Bukti Transfer Saat Ini</div>
                                @if ($keuangan->path_bukti_transfer)
                                    {{-- Tombol diubah menjadi warna hijau --}}
                                    <a href="{{ Storage::url($keuangan->path_bukti_transfer) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out shadow-lg">
                                        <i class="fas fa-file-alt me-2"></i> Lihat Bukti Lama
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500 italic">Belum ada bukti diunggah.</span>
                                @endif
                            </div>

                            <hr class="border-gray-200 mb-4">

                            <label for="bukti_transfer" class="block text-sm font-semibold text-gray-700 mb-2">Ganti Bukti
                                Transfer (PDF/Gambar)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="bukti_transfer"
                                    class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        {{-- Ikon diubah menjadi warna hijau --}}
                                        <i class="fas fa-cloud-upload-alt text-3xl text-green-500 mb-1"></i>
                                        <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Klik untuk
                                                upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">Maks. 5MB (PDF atau Gambar)</p>
                                    </div>
                                    <input id="bukti_transfer" name="bukti_transfer" type="file" class="hidden"
                                        accept=".pdf, image/*" />
                                </label>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 text-center">Kosongkan kolom ini jika tidak ingin mengganti
                                bukti transfer yang sudah ada.</p>
                            @error('bukti_transfer')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>

            </div>
            {{-- AKHIR CONTAINER UTAMA --}}

            {{-- Footer Tombol Aksi --}}
            <hr class="my-10 border-gray-300">
            <div class="flex justify-end space-x-4">
                {{-- Tombol utama diubah menjadi warna hijau --}}
                <button type="submit"
                    class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-bold rounded-xl shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-green-500 transition duration-300 ease-in-out transform hover:scale-[1.02]">
                    <i class="fas fa-save me-3"></i> Perbarui Data
                </button>
                <a href="{{ route('bpdpks.keuangan.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl shadow-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection