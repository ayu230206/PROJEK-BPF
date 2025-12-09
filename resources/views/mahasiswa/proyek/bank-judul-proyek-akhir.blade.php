@extends('mahasiswa.layouts.app')

@section('content')
<div class="p-6">
    <a href="{{ route('mahasiswa.proyek.dashboard') }}"
       class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-700 via-gray-800 to-gray-900 text-white rounded-full hover:from-gray-800 hover:via-gray-900 hover:to-black transition-all duration-500 text-sm font-semibold shadow-2xl hover:shadow-3xl transform hover:scale-110 hover:rotate-1 overflow-hidden">
        <span class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 opacity-0 group-hover:opacity-20 transition-opacity duration-500 rounded-full"></span>
        <svg class="w-5 h-5 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span class="relative z-10">Kembali ke Dashboard Proyek</span>
    </a>
</div>

<div class="text-center mb-8 mt-6">
    <h1 class="text-4xl font-extrabold mb-2 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
        Bank Judul Proyek Akhir
    </h1>
    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full"></div>
</div>

<p class="mb-8 text-gray-700 text-center text-lg leading-relaxed max-w-2xl mx-auto">
    Halaman ini berisi daftar judul-judul proyek akhir yang dapat dijadikan referensi. Temukan inspirasi untuk proyek Anda!
</p>

{{-- ✅ DATA DARI DATABASE --}}
@if(isset($data) && $data->count() > 0)
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($data as $item)
            <div class="p-6 border-l-4 border-blue-500 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-blue-700 leading-tight">{{ $item->judul }}</h3>
                </div>
                <p class="text-sm text-gray-500 mb-2 font-medium">Bidang: <span class="text-indigo-600">{{ $item->bidang }}</span></p>
                <p class="text-gray-700 mt-2 leading-relaxed">{{ $item->deskripsi }}</p>
            </div>
        @endforeach
    </div>
@else
    <div class="p-8 bg-gradient-to-r from-yellow-100 to-orange-100 border-l-4 border-yellow-400 rounded-2xl shadow-lg text-center">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-yellow-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <p class="text-yellow-800 text-lg font-semibold">Data bank judul proyek belum tersedia.</p>
        </div>
    </div>
@endif
@endsection
