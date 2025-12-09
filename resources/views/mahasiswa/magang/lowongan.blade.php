@extends('mahasiswa.layouts.app')
@section('title', 'Daftar Lowongan Magang')

@section('content')

<div class="min-h-screen py-8 bg-gradient-to-br from-green-50 to-white">

<h1 class="text-4xl font-extrabold text-green-900 mb-8 text-center tracking-tight">Lowongan Magang</h1>


<div class="min-h-screen bg-white max-w-6xl mx-auto py-8">
    
    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl text-center shadow-xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-2xl text-center shadow-xl">
            {{ session('error') }}
        </div>
    @endif


    {{-- ======================== --}}
    {{-- 2 BUTTON BARU DI TAMBAHKAN --}}
    {{-- ======================== --}}
    <div class="flex gap-4 mb-8">
        <a href="{{ route('mahasiswa.magang.ajukan') }}" 
            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl shadow-lg font-semibold transition duration-150">
            📄 Ajukan Pengajuan Magang
        </a>

        <a href="{{ route('mahasiswa.magang.index') }}" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg font-semibold transition duration-150">
            📘 Riwayat Pengajuan Magang
        </a>
    </div>
    {{-- ======================== --}}

    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">
            <i class="fas fa-briefcase mr-2 text-yellow-600"></i> Lowongan Magang
        </h1>
    </div>

    @if ($lowongan->isEmpty())
        <div class="text-center p-10 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xl text-gray-500">Saat ini belum ada lowongan magang yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($lowongan as $item)
                @php
                    $isApplied = in_array($item->id, $appliedLowonganIds);
                @endphp
                <div class="bg-white rounded-lg shadow-xl hover:shadow-2xl transition duration-300 border @if($isApplied) border-green-500 @else border-gray-200 @endif p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $item->judul }}</h2>
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-clock mr-2"></i> 
                        @if ($item->deadline)
                            Deadline: <span class="font-medium text-red-600 ml-1">{{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</span>
                        @else
                            <span class="font-medium">Tidak Ada Deadline</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-700 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($item->deskripsi), 150, '...') }}
                    </p>

                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('mahasiswa.magang.lowongan.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition">
                            Lihat Detail
                        </a>

                        @if($isApplied)
                            <span class="text-sm font-bold text-green-600 bg-green-100 px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> Sudah Melamar
                            </span>
                        @else
                            <a href="{{ route('mahasiswa.magang.lowongan.show', $item->id) }}" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-150 text-sm shadow-md">
                                Lamar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
