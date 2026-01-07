@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Detail Lamaran')

@section('content')

    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-search me-2"></i> Detail Lamaran
            </h1>
            <p class="text-sm opacity-85 mt-1">Tinjau data pelamar dan dokumen yang diunggah untuk lowongan ini.</p>
        </div>
    </div>

    
    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">

        {{-- Section 1: Data Pelamar --}}
        <h4 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b"><i class="fas fa-user me-2 text-green-700"></i>
            Data Pelamar</h4>

        <div class="row mb-4">
            <div class="col-md-6">
                <p class="mb-2"><strong>Nama:</strong> {{ $aplikasi->mahasiswa->nama_lengkap }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $aplikasi->mahasiswa->email }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-2"><strong>Kampus:</strong>
                    {{ $aplikasi->mahasiswa->detail->kampus->nama_kampus ?? '-' }}
                </p>
                <p class="mb-2"><strong>Status Aplikasi:</strong> {!! $aplikasi->getStatusBadge() !!}</p>
            </div>
        </div>

        <hr class="my-4">

        {{-- Section 2: Dokumen Lamaran --}}
        <h4 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b mt-4"><i
                class="fas fa-file-alt me-2 text-green-700"></i> Dokumen Lamaran</h4>

        {{-- CV --}}
        <div class="mt-3 p-3 border rounded-lg bg-gray-50">
            <h5 class="text-base font-medium mb-2">Curriculum Vitae (CV)</h5>
            @if($cv)
                {{-- Tombol Lihat (Info/Biru) --}}
                <a href="{{ asset('storage/' . $cv) }}" target="_blank"
                    class="btn btn-sm text-white bg-blue-500 hover:bg-blue-600 me-2">
                    <i class="fas fa-eye me-1"></i> Lihat
                </a>

                {{-- Tombol Download (Success/Hijau) --}}
                <a href="{{ asset('storage/' . $cv) }}" download class="btn btn-sm text-white bg-green-600 hover:bg-green-700">
                    <i class="fas fa-download me-1"></i> Download CV
                </a>
            @else
                <span class="text-danger">CV belum diunggah</span>
            @endif
        </div>

        {{-- PORTOFOLIO --}}
        <div class="mt-4 p-3 border rounded-lg bg-gray-50">
            <h5 class="text-base font-medium mb-2">Portofolio</h5>
            @if($portofolio)
                {{-- Tombol Lihat (Info/Biru) --}}
                <a href="{{ asset('storage/' . $portofolio) }}" target="_blank"
                    class="btn btn-sm text-white bg-blue-500 hover:bg-blue-600 me-2">
                    <i class="fas fa-eye me-1"></i> Lihat
                </a>

                {{-- Tombol Download (Success/Hijau) --}}
                <a href="{{ asset('storage/' . $portofolio) }}" download
                    class="btn btn-sm text-white bg-green-600 hover:bg-green-700">
                    <i class="fas fa-download me-1"></i> Download Portofolio
                </a>
            @else
                <span class="text-secondary">Portofolio tidak diunggah</span>
            @endif
        </div>

        <hr class="my-4">

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ url()->previous() }}"
                class="btn btn-secondary bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white shadow-md transition duration-150">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
@endsection