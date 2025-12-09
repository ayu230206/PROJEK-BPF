@extends('mahasiswa.layouts.app')

@section('title', $lowongan->judul)

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">

        <!-- Header Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border-l-4 border-green-500">
            <h1 class="text-3xl font-bold text-green-900 mb-2">{{ $lowongan->judul }}</h1>
            <p class="text-lg text-green-700 font-medium mb-4">{{ $lowongan->perusahaan }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <span class="text-green-800 font-medium">Gaji: {{ $lowongan->gaji ?? '-' }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-green-600">Lokasi: {{ $lowongan->lokasi ?? '-' }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-600">Status: <span class="{{ $lowongan->status == 'aktif' ? 'text-green-600' : 'text-red-600' }} font-medium">{{ ucfirst($lowongan->status) }}</span></span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-600">Diposting: {{ $lowongan->tanggal_post }}</span>
                </div>
            </div>
        </div>

        <!-- Deskripsi Section -->
        <div class="mt-4 bg-white p-5 border border-green-200 shadow-lg rounded-lg">
            {!! nl2br(e($lowongan->deskripsi)) !!}
        </div>

        @if(session('success'))
            <div class="mt-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if($lowongan->status === 'buka')
        <h2 class="text-xl font-bold mt-8 mb-3 text-green-900">Lamar Pekerjaan</h2>

        <form action="{{ route('mahasiswa.lowongankerja.lamaran.store', $lowongan->lowongan_id) }}" method="POST" enctype="multipart/form-data"
              class="bg-white p-5 border border-green-200 shadow-lg rounded-lg">
            @csrf

            <div class="mb-4">
                <label class="font-semibold text-green-900">Upload CV (PDF)</label>
                <input type="file" name="cv" accept="application/pdf" class="w-full p-3 border border-green-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" required>
                @error('cv')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-semibold text-green-900">Portofolio (opsional)</label>
                <input type="file" name="portofolio" class="w-full p-3 border border-green-300 rounded-lg mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                @error('portofolio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
                Kirim Lamaran
            </button>
        </form>
        @else
            <p class="mt-6 text-red-600 font-semibold bg-white p-4 border border-red-200 shadow-lg rounded-lg">
                Lowongan ini sudah ditutup, tidak bisa melamar.
            </p>
        @endif
    </div>
</div>
@endsection