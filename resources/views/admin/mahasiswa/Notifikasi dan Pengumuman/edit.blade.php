<!-- Menggunakan layout utama admin. Anda mungkin perlu menyesuaikan nama layout jika berbeda. -->
@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Notifikasi / Pengumuman</h1>
        <a href="{{ route('admin.notifikasi.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Form untuk Update Notifikasi -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form action="{{ route('admin.notifikasi.update', $notifikasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Judul Notifikasi -->
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman/Notifikasi</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $notifikasi->judul) }}" 
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('judul') border-red-500 @enderror" 
                       required maxlength="255">
                @error('judul')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Notifikasi -->
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Notifikasi</label>
                <select name="jenis" id="jenis" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jenis') border-red-500 @enderror">
                    <option value="">Pilih Jenis</option>
                    <option value="umum" {{ old('jenis', $notifikasi->jenis) == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="pencairan" {{ old('jenis', $notifikasi->jenis) == 'pencairan' ? 'selected' : '' }}>Informasi Pencairan Dana</option>
                    <option value="registrasi_ulang" {{ old('jenis', $notifikasi->jenis) == 'registrasi_ulang' ? 'selected' : '' }}>Pemberitahuan Registrasi Ulang</option>
                    <!-- Tambahkan jenis lain jika ada -->
                </select>
                @error('jenis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Pesan -->
            <div class="mb-6">
                <label for="isi_pesan" class="block text-sm font-medium text-gray-700 mb-2">Isi Pesan/Detail Pengumuman</label>
                <!-- Anda bisa menggunakan textarea sederhana atau editor WYSIWYG seperti Trix/TinyMCE jika diinstal -->
                <textarea name="isi_pesan" id="isi_pesan" rows="8" 
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('isi_pesan') border-red-500 @enderror" 
                          required>{{ old('isi_pesan', $notifikasi->isi_pesan) }}</textarea>
                @error('isi_pesan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection