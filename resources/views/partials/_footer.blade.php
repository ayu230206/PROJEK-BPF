@extends('admin.layout.app')

@section('body')

    {{-- 1. Navbar (Fixed Top) --}}
    @include('partials._navbar', ['userRole' => 'Admin'])

    {{-- 2. Sidebar (Fixed Left) --}}
    @include('admin.layout._sidebar')

    {{-- 3. WRAPPER UTAMA (Flex Column) --}}
    <div class="content-shifted d-flex flex-column min-vh-100" style="padding-top: 90px;">
        
        {{-- Konten Utama (Grow agar mengisi ruang kosong) --}}
        <main class="flex-grow-1 p-4">
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
            
        </main>

        {{-- 4. Footer (Akan selalu di bawah karena flex-grow-1 di main) --}}
        @include('partials._footer')

    </div>

    {{-- Floating WhatsApp --}}
    <a href="https://wa.me/6281234567890" target="_blank"
       style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background-color: #25d366; color: white; border-radius: 50%; text-align: center; font-size: 35px; box-shadow: 2px 2px 10px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; justify-content: center; text-decoration: none;">
        <i class="fab fa-whatsapp"></i>
    </a>

@endsection