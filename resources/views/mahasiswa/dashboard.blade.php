@extends('mahasiswa.layouts.app')

@section('content')
<div x-data="{ menu: 'dashboard' }" class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 p-4 md:p-6">

    <div x-show="menu==='dashboard'" x-transition class="space-y-10">

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-4">
                Dashboard Mahasiswa
            </h1>
            <p class="text-lg text-gray-600">
                Kelola proyek, magang, dan aktivitas Anda dengan mudah.
            </p>
        </div>

        <!-- ✅ GRID 2 x 2 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

            <!-- IPK Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all min-h-[260px] flex flex-col justify-between">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-4">IPK Terakhir</h2>
                    </div>

                    <p class="text-gray-600">Pantau nilai Indeks Prestasi Kumulatif Anda.</p>
                </div>

                <div class="text-3xl font-bold text-blue-600 mt-4">
                    {{ $akademik?->ipk ?? '' }}
                </div>

                <a href="{{ route('mahasiswa.akademik.ipk') }}"
                    class="mt-4 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">
                    Lihat IPK
                </a>
            </div>


            <!-- ✅ MAGANG CARD (DITAMBAH BUTTON LIHAT PENGAJUAN) -->
            <div
                class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all min-h-[260px] flex flex-col justify-between">

                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-4">Pengajuan Magang</h2>
                    </div>

                    <p class="text-gray-600">
                        Lihat status pengajuan magang Anda.
                    </p>
                </div>

                <!-- ✅ BUTTON LIHAT PENGAJUAN -->
                <a href="{{ route('mahasiswa.magang.index') }}"
                    class="mt-4 w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 rounded-xl transition-all duration-300 shadow-md">
                    Lihat Pengajuan
                </a>

            </div>


            <!-- LOMBA Card -->
            <a href="{{ route('mahasiswa.info-lomba') }}"
                class="block bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all min-h-[260px] flex flex-col justify-between">

                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-4">Info Lomba</h2>
                    </div>

                    <p class="text-gray-600">
                        Lihat informasi lomba.
                    </p>
                </div>

                <button
                    class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-xl transition-all duration-300 shadow-md">
                    Lihat Detail
                </button>
            </a>

            <!-- Penelitian Card -->
            <a href="{{ route('mahasiswa.penelitian') }}"
                class="block bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all min-h-[260px] flex flex-col justify-between">

                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-teal-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-4">Penelitian dan Riset</h2>
                    </div>

                    <p class="text-gray-600 mb-6">
                        Temukan berbagai penelitian terbaru yang dapat Anda ikuti.
                    </p>

                    <div class="mt-auto">
                        <button
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md">
                            Lihat Penelitian
                        </button>
                    </div>
                </div>
            </a>


        </div>
    </div>
</div>
@endsection