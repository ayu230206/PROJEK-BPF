@extends('admin.layout.app')

@section('body')
    
    {{-- WRAPPER UTAMA: Mendorong konten ke bawah FIXED Navbar --}}
    <div class="body-padding-for-fixed-navbar d-flex flex-column min-vh-100">

        {{-- 1. Navbar (Fixed Top) --}}
        @include('partials._navbar', ['userRole' => 'Admin'])

        {{-- 2. Sidebar (Fixed Left) --}}
        @include('admin.layout._sidebar')

        {{-- 3. Area Konten Utama --}}
        <main class="flex-grow-1 p-5 content-shifted konten-utama-bpdpks" style="min-height: 100vh;">
            {{-- Catatan: padding-top: 90px sudah dipindahkan ke body-padding-for-fixed-navbar --}}
            
            <div class="konten-sebenarnya container-fluid p-4">
                
                {{-- Flash Messages (Notifikasi Sukses/Gagal) --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 fs-4"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                {{-- Konten Halaman Dinamis --}}
                @yield('content')
                
            </div>
            
            {{-- Memanggil Footer di sini (opsional, tergantung preferensi) --}}
            {{-- Jika menggunakan komponen footer.blade.php yang baru, pastikan ia memiliki class content-shifted --}}

        </main>
        
    </div>

@endsection