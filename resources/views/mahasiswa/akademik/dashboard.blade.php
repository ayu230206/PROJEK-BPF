@extends('mahasiswa.layouts.app')
@section('title', 'Dashboard Akademik')

@section('content')
<div class="bg-gradient-to-br from-green-100 via-blue-50 to-purple-100 min-h-screen py-12 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        
        {{-- ✅ IPK (SEKARANG BISA DIKLIK KE ROUTE mahasiswa.akademik.ipk) --}}
        <a href="{{ route('mahasiswa.akademik.ipk') }}"
           class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 text-center 
                  hover:shadow-3xl hover:scale-105 transition-all duration-300 
                  ease-in-out border border-white/20 block group">

            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-blue-600 group-hover:text-blue-800 transition-colors"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-700 mb-2 group-hover:text-gray-900">
                IPK
            </h2>

            <p class="text-4xl font-extrabold text-blue-600 mt-4">
                {{ $akademik->ipk ?? '' }}
            </p>
        </a>

        {{-- Upload Dokumen --}}
        <a href="{{ route('mahasiswa.akademik.upload.page') }}" 
           class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 text-center 
                  hover:shadow-3xl hover:scale-105 transition-all duration-300 
                  ease-in-out border border-white/20 block group">

            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-purple-600 group-hover:text-purple-800 transition-colors"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 
                        6L16 6a5 5 0 011 9.9M15 
                        13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-700 mb-2 group-hover:text-gray-900">
                Upload Dokumen
            </h2>

            <p class="mt-4 text-gray-600 group-hover:text-gray-800">
                Klik untuk upload dokumen baru
            </p>
        </a>

    </div>
</div>
@endsection
