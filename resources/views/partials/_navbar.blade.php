@php
    $logoUrl = asset('img/logo-bpdpks-3_169.png');
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('settings/website_logo.png')) {
        $logoUrl = asset('storage/settings/website_logo.png');
    }
@endphp

{{-- Hapus 'bg-dark', gunakan style palm-green --}}
<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4 shadow-sm" 
     style="height: 90px; background-color: var(--palm-green); z-index: 1050; border-bottom: 1px solid rgba(255,255,255,0.1);">
    
    <div class="container-fluid">
        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <img src="{{ $logoUrl }}?v={{ time() }}" 
                 alt="Logo SIBS" 
                 class="d-inline-block align-text-top me-3 bg-white rounded p-1 shadow-sm" 
                 style="height: 50px; width: auto; object-fit: contain;">
            <div class="d-flex flex-column">
                <span class="text-white fs-5 lh-1">SIBS</span>
                <span class="text-warning small lh-1" style="font-size: 0.75rem;">Beasiswa Sawit</span>
            </div>
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="#" class="btn btn-sm btn-outline-warning fw-bold px-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>

        {{-- KANAN --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <div class="d-flex align-items-center ms-auto">
                {{-- Form Logout --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
                <a href="#" class="btn btn-sm btn-outline-warning fw-bold px-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>