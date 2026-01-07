@extends('mahasiswa.layouts.app')
@section('title', $lowongan->judul)

@section('content')

<div class="min-h-screen bg-green-50 w-full py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-start">
    
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden p-8 max-w-3xl w-full">
        <div class="flex flex-col md:flex-row justify-between items-start border-b pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-green-900 mb-1">{{ $lowongan->judul }}</h1>
                <p class="text-sm text-green-700">Diposting oleh: {{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin BPDPKS' }}</p>
            </div>
            <div class="text-right mt-4 md:mt-0">
                <span class="text-lg font-bold text-red-600">Deadline:</span>
                <p class="text-xl font-bold @if($lowongan->deadline < now()) text-red-600 @else text-green-600 @endif">
                    {{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : 'Tidak Ada' }}
                </p>
            </div>
        </div>

        {{-- 🔹 FOTO DAN FILE PENDUKUNG --}}
        @if($lowongan->foto)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $lowongan->foto) }}" alt="Foto Lowongan" class="rounded-lg shadow-lg w-full max-h-64 object-cover">
            </div>
        @endif

        @if($lowongan->file_pendukung)
            <div class="mb-4">
                <a href="{{ asset('storage/' . $lowongan->file_pendukung) }}" target="_blank" class="text-blue-700 font-semibold underline">
                    Download File Persyaratan
                </a>
            </div>
        @endif

        @if ($sudahMelamar)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-lg shadow-inner" role="alert">
                <p class="font-bold flex items-center"><i class="fas fa-check-circle mr-2"></i> Anda Sudah Melamar Lowongan Ini</p>
                <p class="text-sm">Silakan cek status aplikasi Anda di <strong>Portal Magang</strong>.</p>
            </div>

        @elseif ($lowongan->deadline && $lowongan->deadline < now())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-lg shadow-inner" role="alert">
                <p class="font-bold flex items-center"><i class="fas fa-exclamation-triangle mr-2"></i> Maaf, Lowongan Ini Sudah Ditutup</p>
            </div>

        @else
            {{-- 🔥 FORM BARU: Upload CV & Portofolio --}}
            <form action="{{ route('mahasiswa.magang.lowongan.apply', $lowongan->id) }}" 
                  method="POST" enctype="multipart/form-data" class="mb-6">
                @csrf

                <div class="mb-4">
                    <label class="font-semibold text-green-900">Upload CV (PDF)</label>
                    <input type="file" name="cv" accept="application/pdf" required
                           class="w-full p-3 border border-green-300 rounded-lg mt-1">
                    @error('cv')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-green-900">Portofolio (opsional)</label>
                    <input type="file" name="portofolio"
                           class="w-full p-3 border border-green-300 rounded-lg mt-1">
                    @error('portofolio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150 text-lg shadow-lg flex justify-center items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Lamaran Sekarang
                </button>
            </form>
        @endif

        <h2 class="text-2xl font-semibold text-green-800 border-b mt-6 pb-2 mb-4">Deskripsi Magang</h2>
        <div class="prose max-w-none text-green-700 mb-6">
            {!! nl2br(e($lowongan->deskripsi)) !!}
        </div>

        <h2 class="text-2xl font-semibold text-green-800 border-b pb-2 mb-4">Kualifikasi / Persyaratan</h2>
        <div class="prose max-w-none text-green-700">
            {!! nl2br(e($lowongan->kualifikasi)) !!}
        </div>
        
        <div class="mt-8 pt-4 border-t flex justify-start">
            <a href="{{ route('mahasiswa.magang.lowongan') }}" 
               class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-150">
                 Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>
</div>

@endsection
