@extends('mahasiswa.layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between bg-white/70 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/20">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Notifikasi</h1>
            </div>

            {{-- Tombol Hapus Semua --}}
            @if($notifikasi->count() > 0)
            <form action="{{ route('mahasiswa.notifikasi.destroyAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                    Hapus Semua
                </button>
            </form>
            @endif
        </div>

        {{-- Daftar Notifikasi --}}
        @forelse($notifikasi as $item)
        @php
        $title = $item->data['title'] ?? $item->data['judul'] ?? '';
        $message = $item->data['message'] ?? $item->data['pesan'] ?? '';

        $isMagang = str_contains(strtolower($title), 'magang')
        || str_contains(strtolower($message), 'magang');

        if ($isMagang) {
        $link = route('mahasiswa.magang.index');
        } elseif (!empty($item->data['url'])) {
        $link = $item->data['url'];
        } elseif (!empty($item->data['link'])) {
        $link = $item->data['link'];
        } else {
        $link = route('mahasiswa.dashboard');
        }
        @endphp

        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl p-6 mb-6 border border-white/30 hover:shadow-xl hover:bg-white/90 transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-start gap-5">

                {{-- Icon --}}
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-2xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                </div>

                {{-- Isi --}}
                <div class="flex-1">
                    <h2 class="font-bold text-gray-800 text-xl mb-2">
                        {{ $title ?: 'Tidak ada judul' }}
                    </h2>

                    <p class="text-gray-700 mt-2 leading-relaxed">
                        {{ $message ?: 'Tidak ada pesan' }}
                    </p>

                    <p class="text-gray-500 text-sm mt-3 font-medium">
                        {{ $item->created_at->diffForHumans() }}
                    </p>

                    <div class="mt-4 flex gap-4 items-center">
                        <a href="{{ $link }}" class="text-blue-600 hover:text-indigo-700 font-semibold text-sm transition-colors duration-200 hover:underline">
                            Lihat Detail 
                        </a>

                        {{-- Tombol hapus notifikasi --}}
                        <form action="{{ route('mahasiswa.notifikasi.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-500 hover:text-red-600 font-semibold text-sm transition-colors duration-200 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-white/30 text-center text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-.98-5.5-2.5" />
            </svg>
            <p class="text-lg font-medium">Tidak ada notifikasi.</p>
        </div>
        @endforelse
    </div>
</div>
</div>
@endsection