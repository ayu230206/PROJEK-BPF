@extends('mahasiswa.layouts.app')
@section('title', 'Upload Dokumen')

@section('content')
<div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen py-12 px-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold text-green-900 mb-2">
                Upload Dokumen Mahasiswa
            </h1>
            <p class="text-lg text-green-700">Kelola dokumen akademik Anda dengan mudah</p>
        </div>
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('mahasiswa.akademik.dashboard') }}"
                class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- Form Upload Dokumen --}}
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 mb-8 border border-white/20">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800">Form Upload Dokumen</h2>
            </div>
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('mahasiswa.akademik.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-700 mb-3">Nama Dokumen</label>
                    <input type="text" name="jenis" placeholder="Contoh: KTP / KTM / Transkrip"
                        class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300"
                        required>
                </div>
                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-700 mb-3">Pilih File</label>
                    <input type="file" name="dokumen"
                        class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300"
                        accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload Dokumen
                </button>
            </form>
        </div>

        {{-- Daftar Dokumen --}}
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 border border-white/20">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Dokumen</h2>
            </div>

            @forelse($dokumen as $d)
            <div class="flex justify-between items-center p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl mb-4 hover:shadow-lg hover:scale-102 transition-all duration-300 border border-gray-200">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <strong class="text-lg text-gray-800">{{ $d->jenis ?? 'Dokumen' }}</strong>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ asset('storage/'.$d->file_path) }}" target="_blank"
                        class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat
                    </a>
                    <form action="{{ route('mahasiswa.akademik.dokumen.destroy', $d->id) }}"
                        method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 font-semibold hover:underline transition-colors duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-xl text-gray-500">Belum ada dokumen yang diunggah.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection