@extends('mahasiswa.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 p-6">

    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl  font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-600">
            Data Akademik Mahasiswa
        </h1>
        <p class="text-gray-600 mt-2">Informasi IPK dan Akademik Anda</p>
    </div>

    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

        <!-- Identitas -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-gray-500 text-sm">Nama</p>
                <p class="font-semibold text-lg">
                    {{ $mahasiswa->user->nama_lengkap ?? auth()->user()->nama_lengkap ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">NIM</p>
                <p class="font-semibold text-lg">
                    {{ $mahasiswa->nim ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Kampus</p>
                <p class="font-semibold text-lg">
                    {{ $mahasiswa->kampus->nama_kampus ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Program Studi</p>
                <p class="font-semibold text-lg">
                    {{ $mahasiswa->program_studi ?? '-' }}
                </p>
            </div>
        </div>

        <!-- NILAI (IPK) -->
        <div class="grid md:grid-cols-1 gap-6">
            <div class="bg-blue-50 rounded-2xl p-6 text-center">
                <p class="text-gray-600">IPK Saat Ini</p>
                @if(isset($mahasiswa) && $mahasiswa->ipk)
                    <h2 class="text-4xl font-extrabold text-blue-600 mt-2">
                        {{ $mahasiswa->ipk }}
                    </h2>
                    <div class="mt-3">
                        {!! $mahasiswa->ipk_badge ?? '<span class="text-gray-500">Belum ada badge IPK</span>' !!}
                    </div>
                @else
                    <h2 class="text-lg font-semibold text-red-600 mt-2">
                        IPK Anda belum diinputkan
                    </h2>
                @endif
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8 text-center">
            <a href="{{ route('mahasiswa.akademik.dashboard') }}"
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-xl transition">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
