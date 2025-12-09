@extends('mahasiswa.layouts.app')
@section('title', 'Daftar Penelitian')
@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">

    <h1 class="text-4xl font-extrabold text-green-800 text-center mb-12">
        Daftar Penelitian
    </h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('mahasiswa.penelitian') }}" class="max-w-2xl mx-auto mb-10">
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <input
                type="text"
                name="q"
                placeholder="Cari judul atau penyelenggara..."
                value="{{ request('q') }}"
                class="flex-1 p-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none transition">
            <button
                type="submit"
                class="w-full sm:w-auto bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                Cari
            </button>
        </div>
    </form>

    {{-- Daftar Penelitian --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse ($penelitian as $item)
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 hover:shadow-xl hover:scale-105 transition-transform duration-300 flex flex-col justify-between">

            {{-- Judul --}}
            <h2 class="text-xl md:text-2xl font-bold text-teal-700 mb-3">
                {{ $item->judul }}
            </h2>

            {{-- Penyelenggara --}}
            <p class="text-gray-600 mb-1">
                <span class="font-semibold text-gray-700">Penyelenggara:</span> {{ $item->penyelenggara ?? '-' }}
            </p>

            {{-- Tanggal --}}
            <p class="text-gray-600 mb-3">
                <span class="font-semibold text-gray-700">Tanggal:</span>
                {{ $item->tanggal_mulai?->format('d M Y') }} - {{ $item->tanggal_berakhir?->format('d M Y') }}
            </p>

            {{-- Deskripsi --}}
            @if($item->deskripsi)
            <p class="text-gray-600 font-semibold">Deskripsi:</p>
            <p class="text-gray-700 mb-4 leading-relaxed">
                {{ Str::limit($item->deskripsi, 180) }}
            </p>
            @endif

            
        </div>
        @empty
        <p class="text-center text-gray-500 col-span-full">Tidak ada penelitian ditemukan.</p>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="mt-10 flex justify-center">
        {{ $penelitian->links() }}
    </div>

</div>
@endsection