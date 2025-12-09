<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top padding-top: 60px">
    <div class="container-fluid">
        {{-- Navbar brand will be hidden on mobile since we show the sidebar anyway, but kept for desktop --}}
        <a class="navbar-brand fw-bold d-none d-lg-block" href="#">
            <i class="fas fa-leaf me-2 text-warning"></i>SIBS ADMIN
        </a>

        {{-- Toggle button for mobile sidebar --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Right side (Logout/User info) --}}
        <div class="d-flex align-items-center ms-auto">
            <span class="me-3 text-white-50 d-none d-md-inline">Halo, {{ $adminName ?? 'Admin' }}</span>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf 
            </form>
            <a href="#" class="btn btn-sm btn-outline-warning" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>