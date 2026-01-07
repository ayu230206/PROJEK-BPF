@extends('mahasiswa.layouts.app')

@section('title', $lowongan->judul)

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">

        @php
            $isClosed = $lowongan->status == 'tutup' || now()->gt(\Carbon\Carbon::parse($lowongan->tanggal_deadline));
        @endphp

        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border-l-4 border-green-500">
            <h1 class="text-3xl font-bold text-green-900 mb-2">{{ $lowongan->judul }}</h1>
            <p class="text-lg text-green-700 font-medium mb-4">{{ $lowongan->perusahaan }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center">
                    <span class="text-green-800 font-medium">
                        Gaji: {{ $lowongan->gaji ?? '-' }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-green-600">
                        Lokasi: {{ $lowongan->lokasi ?? '-' }}
                    </span>
                </div>
                <div class="flex items-center">
                    Status:
                    <span class="{{ $isClosed ? 'text-red-600' : 'text-green-600' }} font-medium ml-1">
                        {{ $isClosed ? 'Tutup' : 'Aktif' }}
                    </span>
                </div>
                <div class="flex items-center">
                    Deadline: {{ $lowongan->tanggal_deadline }}
                </div>
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

        <div class="mt-4 bg-white p-5 border border-green-200 shadow-lg rounded-lg">
            {!! nl2br(e($lowongan->deskripsi)) !!}
        </div>

        @if(!$isClosed)
        <h2 class="text-xl font-bold mt-8 mb-3 text-green-900">Lamar Pekerjaan</h2>

        <form action="{{ route('mahasiswa.lowongankerja.lamaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data"
              class="bg-white p-5 border border-green-200 shadow-lg rounded-lg">
            @csrf

            <div class="mb-4">
                <label class="font-semibold text-green-900">Upload CV (PDF)</label>
                <input type="file" name="cv" accept="application/pdf"
                       class="w-full p-3 border border-green-300 rounded-lg mt-1" required>
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

            <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg shadow-lg">
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
