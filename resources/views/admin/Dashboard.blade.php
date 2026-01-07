@extends('admin.layout.LayoutAdmin')

@section('title', 'Dashboard')

@section('content')
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-sawit-utama">
            Selamat Datang Admin
        </h1>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600 hidden sm:inline">Administrator Panel</span>
            <div class="w-10 h-10 bg-sawit-highlight rounded-full flex items-center justify-center text-sawit-utama font-bold">
                A
            </div>
        </div>
    </header>

    {{-- Bagian Statistik Ringkas --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        {{-- CARD 1: User BPDPKS Online (Menggantikan Total Penerima) --}}
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-utama">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">User BPDPKS Online</div>
                <i class="fas fa-user-tie w-8 h-8 text-sawit-utama fs-3"></i>
            </div>
            {{-- Menggunakan null coalescing (??) agar tidak error jika data belum ada di controller --}}
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['bpdpks_online'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">Sedang aktif</p>
        </div>

        {{-- CARD 2: Mahasiswa Aktif (Tetap) --}}
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Mahasiswa Aktif</div>
                <i class="fas fa-user-check w-8 h-8 text-green-500 fs-3"></i>
            </div>
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['mahasiswa_aktif'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">Status aktif</p>
        </div>
        
        {{-- CARD 3: Kerjasama Kampus (Menggantikan Dana Tersalurkan) --}}
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-highlight">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Kerjasama Kampus</div>
                <i class="fas fa-handshake w-8 h-8 text-sawit-highlight fs-3"></i>
            </div>
            {{-- Menggunakan data kampus_kerjasama yang sudah ada di controller --}}
            <p class="text-3xl font-bold text-sawit-utama mt-2">{{ $stats['kampus_kerjasama'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">Total Mitra Kampus</p>
        </div>
        
        {{-- CARD 4: Admin Online (Menggantikan Perlu Verifikasi) --}}
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Admin Online</div>
                <i class="fas fa-user-shield w-8 h-8 text-red-500 fs-3"></i>
            </div>
            {{-- Default ke 1 (Anda sendiri) jika logika online belum dibuat --}}
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['admin_online'] ?? 1 }}</p>
            <p class="text-xs text-gray-400 mt-1">Sedang aktif</p>
        </div>

    </section>

    {{-- Bagian 2: Logo BPDPKS & Notifikasi --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri (2/3): Menampilkan Logo BPDPKS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card-stat p-6 rounded-xl shadow-lg h-full flex flex-col items-center justify-center text-center bg-white">
                <h2 class="text-xl font-semibold mb-6 text-sawit-utama w-full text-left border-b pb-2">
                    <i class="fas fa-image me-2"></i> Mitra Penyelenggara
                </h2>
                
                {{-- Menampilkan Logo BPDPKS --}}
                <div class="flex-grow flex items-center justify-center p-4" style="min-height: 300px;">
                    <img src="{{ asset('img/logo-bpdpks-3_169.png') }}" 
                         alt="Logo BPDPKS" 
                         class="img-fluid" 
                         style="max-height: 250px; width: auto; object-fit: contain;">
                </div>
                
                <p class="text-sm text-gray-500 mt-4">
                    Badan Pengelola Dana Perkebunan Kelapa Sawit
                </p>
            </div>
        </div>

        <!-- Kolom Kanan (1/3): Notifikasi -->
        <div class="lg:col-span-1">
            <div class="card-stat p-6 rounded-xl shadow-lg h-full bg-white">
                <h2 class="text-xl font-semibold mb-4 text-sawit-utama flex items-center border-b pb-2">
                    <i class="fas fa-bell w-6 h-6 mr-2 text-red-500"></i>
                    Notifikasi Terbaru
                </h2>

                <div class="overflow-y-auto" style="max-height: 350px;">
                    @if(count($notifications) > 0)
                        <ul class="space-y-4 pr-2">
                            @foreach ($notifications as $notification)
                                <li class="border-b pb-3 last:border-b-0 border-gray-100">
                                    <a href="{{ $notification['link'] }}" class="block hover:bg-green-50 p-3 rounded-lg transition duration-150 group">
                                        <div class="flex items-start">
                                            <div class="bg-green-100 text-green-600 rounded-full p-1.5 mr-3 mt-0.5 group-hover:bg-green-200 transition">
                                                <i class="fas fa-info-circle text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-sm text-gray-800 group-hover:text-green-800">{{ $notification['title'] }}</p>
                                                <p class="text-xs text-gray-400 mt-1 flex items-center">
                                                    <i class="far fa-clock mr-1"></i> {{ $notification['time'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="far fa-bell-slash text-3xl mb-2"></i>
                            <p class="text-sm">Tidak ada notifikasi baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
