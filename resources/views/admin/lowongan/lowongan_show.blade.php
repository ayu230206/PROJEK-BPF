@extends('mahasiswa.layouts.app')

@section('title', $lowongan->judul)

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        
        {{-- 1. LOGIKA TAMPILAN FILE (GAMBAR vs PDF) --}}
        @if($lowongan->file_path)
            @php
                $extension = pathinfo($lowongan->file_path, PATHINFO_EXTENSION);
            @endphp

            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                {{-- Jika Gambar: Jadikan Banner Header --}}
                <div class="w-full h-64 md:h-80 bg-gray-200 relative group">
                    <img src="{{ asset($lowongan->file_path) }}" 
                         alt="Banner Lowongan" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition duration-300"></div>
                </div>
            @else
                {{-- Jika PDF/Dokumen: Tampilkan Tombol Download --}}
                <div class="bg-blue-50 border-b border-blue-100 p-4 flex items-center justify-between">
                    <div class="flex items-center text-blue-800">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="font-semibold">Dokumen Pendukung Tersedia</span>
                    </div>
                    <a href="{{ asset($lowongan->file_path) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition shadow">
                        Unduh PDF
                    </a>
                </div>
            @endif
        @endif

        {{-- 2. KONTEN UTAMA --}}
        <div class="p-8">
            {{-- Header Judul & Status --}}
            <div class="flex flex-col md:flex-row justify-between items-start mb-6 border-b border-gray-100 pb-6">
                <div>
                    <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wide text-green-800 uppercase bg-green-100 rounded-full mb-2">
                        {{ ucfirst($lowongan->tipe == 'magang' ? 'Program Magang' : 'Lowongan Kerja') }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $lowongan->judul }}</h1>
                    <p class="text-sm text-gray-500">
                        Diposting oleh <span class="font-medium text-gray-700">{{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin' }}</span> 
                        &bull; {{ $lowongan->created_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="mt-4 md:mt-0 text-right">
                    <p class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Batas Pendaftaran</p>
                    <p class="text-xl font-bold {{ $lowongan->deadline < now() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : 'Tanpa Batas' }}
                    </p>
                </div>
            </div>

            {{-- Status Aplikasi User --}}
            @if ($sudahMelamar)
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8 flex items-center text-green-800">
                    <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold">Lamaran Terkirim!</p>
                        <p class="text-sm">Anda sudah melamar posisi ini. Cek status di menu Riwayat.</p>
                    </div>
                </div>
            @elseif ($lowongan->deadline && $lowongan->deadline < now())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8 flex items-center text-red-800">
                    <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold">Pendaftaran Ditutup</p>
                        <p class="text-sm">Maaf, batas waktu pendaftaran untuk posisi ini sudah berakhir.</p>
                    </div>
                </div>
            @endif

            {{-- Deskripsi --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    Deskripsi Pekerjaan
                </h3>
                <div class="prose max-w-none text-gray-600 leading-relaxed bg-gray-50 p-5 rounded-xl border border-gray-100">
                    {!! nl2br(e($lowongan->deskripsi)) !!}
                </div>
            </div>

            {{-- Kualifikasi --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kualifikasi & Syarat
                </h3>
                <div class="prose max-w-none text-gray-600 leading-relaxed bg-gray-50 p-5 rounded-xl border border-gray-100">
                    {!! nl2br(e($lowongan->kualifikasi)) !!}
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                <a href="{{ route('mahasiswa.magang.lowongan') }}" class="text-gray-500 hover:text-gray-700 font-medium transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>

                @if (!$sudahMelamar && ($lowongan->deadline == null || $lowongan->deadline >= now()))
                    <form action="{{ route('mahasiswa.magang.lowongan.apply', $lowongan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Ajukan Lamaran
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection