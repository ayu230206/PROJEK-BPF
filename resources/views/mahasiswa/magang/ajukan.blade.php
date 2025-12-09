@extends('mahasiswa.layouts.app')
@section('title', 'Pendaftaran Magang')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-10 px-4 md:px-6">

    <div class="max-w-5xl mx-auto">

        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('mahasiswa.magang.lowongan') }}"
                class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-2xl transition-all duration-200 shadow-md">
                Kembali
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl text-center shadow-xl animate-pulse">
            {{ session('success') }}
        </div>
        @endif

        {{-- CARD FORM PENDAFTARAN --}}
        <div class="bg-white rounded-3xl shadow-2xl border border-green-200 overflow-hidden hover:shadow-3xl transition-shadow duration-300">

            <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-xl flex items-center gap-3">
                <span class="text-3xl">📝</span>
                @if(isset($lowongan))
                Lamar Lowongan: {{ $lowongan->judul }}
                @else
                Pendaftaran Magang
                @endif
            </div>

            <div class="p-8">

                {{-- FORM --}}
                <form
                    action="{{ isset($lowongan) 
                        ? route('mahasiswa.magang.lowongan.apply', $lowongan->id) 
                        : route('mahasiswa.magang.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6">

                    @csrf

                    {{-- ID Lowongan --}}
                    @if(isset($lowongan))
                    <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                    @endif

                    {{-- Tempat Magang --}}
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Tempat Magang</label>
                        <input type="text"
                            name="tempat_magang"
                            required
                            value="{{ isset($lowongan) ? $lowongan->judul : '' }}"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4"
                            @if(isset($lowongan)) readonly @endif>
                    </div>

                    {{-- Posisi --}}
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Posisi Magang</label>
                        <select name="posisi" required
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4">
                            <option value="" disabled selected>Pilih Posisi Magang</option>

                            {{-- Semua posisi digabung --}}
                            <option value="Operator Lapangan" {{ (isset($lowongan) && $lowongan->posisi == 'Operator Lapangan') ? 'selected' : '' }}>Operator Lapangan</option>
                            <option value="Asisten Produksi" {{ (isset($lowongan) && $lowongan->posisi == 'Asisten Produksi') ? 'selected' : '' }}>Asisten Produksi</option>
                            <option value="Asisten Quality Control" {{ (isset($lowongan) && $lowongan->posisi == 'Asisten Quality Control') ? 'selected' : '' }}>Asisten Quality Control</option>
                            <option value="Administrasi" {{ (isset($lowongan) && $lowongan->posisi == 'Administrasi') ? 'selected' : '' }}>Administrasi</option>
                            <option value="Logistik dan Gudang" {{ (isset($lowongan) && $lowongan->posisi == 'Logistik dan Gudang') ? 'selected' : '' }}>Logistik dan Gudang</option>
                            <option value="Asisten Health, Safety, and Environment" {{ (isset($lowongan) && $lowongan->posisi == 'Asisten Health, Safety, and Environment') ? 'selected' : '' }}>Asisten Health, Safety, and Environment</option>
                            <option value="Pengembangan Perangkat Lunak" {{ (isset($lowongan) && $lowongan->posisi == 'Pengembangan Perangkat Lunak') ? 'selected' : '' }}>Pengembangan Perangkat Lunak</option>
                            <option value="Administrator Jaringan" {{ (isset($lowongan) && $lowongan->posisi == 'Administrator Jaringan') ? 'selected' : '' }}>Administrator Jaringan</option>
                            <option value="Analisis Data / Data Analyst" {{ (isset($lowongan) && $lowongan->posisi == 'Analisis Data / Data Analyst') ? 'selected' : '' }}>Analisis Data / Data Analyst</option>
                            <option value="Pengembangan Web dan Aplikasi Mobile" {{ (isset($lowongan) && $lowongan->posisi == 'Pengembangan Web dan Aplikasi Mobile') ? 'selected' : '' }}>Pengembangan Web dan Aplikasi Mobile</option>
                            <option value="IT Support / Technical Support" {{ (isset($lowongan) && $lowongan->posisi == 'IT Support / Technical Support') ? 'selected' : '' }}>IT Support / Technical Support</option>
                            <option value="Cybersecurity Assistant" {{ (isset($lowongan) && $lowongan->posisi == 'Cybersecurity Assistant') ? 'selected' : '' }}>Cybersecurity Assistant</option>
                        </select>
                    </div>


                    {{-- Deskripsi --}}
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4 min-h-[120px]"
                            @if(isset($lowongan)) readonly @endif>{{ isset($lowongan) ? $lowongan->deskripsi : '' }}</textarea>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-green-900 text-lg">Tanggal Mulai</label>
                            <input type="date" name="mulai"
                                class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4">
                        </div>

                        <div>
                            <label class="font-semibold text-green-900 text-lg">Tanggal Selesai</label>
                            <input type="date" name="selesai"
                                class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4">
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Upload CV / Persyaratan</label>
                        <input type="file" name="file_pendukung" required accept=".pdf,.doc,.docx"
                            class="mt-2 w-full text-sm bg-green-50 border border-green-300 rounded-2xl p-4">
                    </div>

                    {{-- BUTTON SUBMIT --}}
                    <button
                        class="bg-gradient-to-r from-green-700 to-green-600 text-white px-8 py-4 rounded-2xl shadow-xl font-semibold w-full hover:from-green-800 hover:to-green-700 transition-all duration-200">
                        @if(isset($lowongan))
                        Lamar Lowongan
                        @else
                        Kirim Pendaftaran
                        @endif
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection