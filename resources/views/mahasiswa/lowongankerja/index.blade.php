@extends('mahasiswa.layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header + Tombol Riwayat Lamaran -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-500">
            <h1 class="text-3xl font-bold text-green-900 mb-4 md:mb-0">Daftar Lowongan Kerja</h1>

            <!-- Tombol Riwayat Lamaran -->
            <a href="{{ route('mahasiswa.lowongankerja.riwayat') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat Lamaran
            </a>
        </div>

        <!-- Search Form -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-green-200">
            <form method="GET" action="{{ route('mahasiswa.lowongankerja.index') }}" class="flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari berdasarkan judul, perusahaan, atau lokasi..." 
                           value="{{ request('search') }}" 
                           class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
                @if(request('search'))
                <a href="{{ route('mahasiswa.lowongankerja.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition-all duration-300">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Lowongan Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lowongans as $lowongan)
            <div class="bg-white shadow-lg rounded-lg p-6 border border-green-200 hover:shadow-xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1">
                <h2 class="font-bold text-xl text-green-900 mb-2">
                    {!! str_ireplace(request('search'), "<span class='bg-yellow-200'>" . request('search') . "</span>", $lowongan->judul) !!}
                </h2>
                <p class="text-green-700 font-medium mb-1">
                    {!! str_ireplace(request('search'), "<span class='bg-yellow-200'>" . request('search') . "</span>", $lowongan->perusahaan) !!}
                </p>
                <p class="text-sm text-green-600 mb-1">Diposting: {{ $lowongan->tanggal_post }}</p>
                <p class="text-sm text-green-600 mb-1">Gaji: {{ $lowongan->gaji ?? 'Tidak disebutkan' }}</p>
                <p class="text-sm text-green-600 mb-1">Lokasi: {{ $lowongan->lokasi ?? 'Tidak disebutkan' }}</p>
                <p class="text-sm text-green-600 mb-3">Status: <span class="{{ $lowongan->status == 'aktif' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($lowongan->status) }}</span></p>

                <a href="{{ route('mahasiswa.lowongankerja.show', $lowongan->lowongan_id) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-all duration-300">
                    Detail & Lamar
                </a>
            </div>
            @empty
            <div class="col-span-full bg-white shadow-lg rounded-lg p-8 text-center border border-gray-200">
                @if(request('search'))
                    <p class="text-gray-500">Tidak ditemukan lowongan kerja untuk "{{ request('search') }}".</p>
                @else
                    <p class="text-gray-500">Belum ada lowongan kerja yang tersedia.</p>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $lowongans->withQueryString()->links('pagination::tailwind') }}
        </div>

    </div>
</div>
@endsection
