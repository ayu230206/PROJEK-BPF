<nav class="admin-sidebar w-64 p-6 shadow-xl hidden md:block" style="min-height: 100vh;">
    <div class="text-white text-2xl font-bold mb-8 border-b border-green-700 pb-4">
        SIBS ADMIN
    </div>
    <ul class="nav flex-column space-y-2">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-secondary rounded' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mt-3 text-warning text-uppercase small fw-bold px-3">Manajemen Data</li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.kampus.*') ? 'bg-secondary rounded' : '' }}" 
               href="{{ route('admin.kampus.index') }}">
                <i class="fas fa-university me-2"></i> Data Kampus & MoU
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'bg-secondary rounded' : '' }}" 
                href="{{ route('admin.users.index') }}">
                <i class="fas fa-user-plus me-2"></i> Tambah Akun User
            </a>
        </li>

        <li class="nav-item mt-3 text-warning text-uppercase small fw-bold px-3">Program & Kegiatan</li>

        {{-- <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.penelitian-lomba.*') ? 'bg-secondary rounded' : '' }}" 
               href="{{ route('admin.penelitian-lomba.index') }}">
                <i class="fas fa-trophy me-2"></i> Data Lomba
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.lowongan.index') ? 'bg-secondary rounded' : '' }}" 
               href="{{ route('admin.lowongan.index') }}">
                <i class="fas fa-briefcase me-2"></i> Lowongan & Magang
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.forum.*') ? 'bg-secondary rounded' : '' }}" 
                href="{{ route('admin.forum.index') }}">
                <i class="fas fa-comments me-2"></i> Moderasi Forum
            </a>
        </li>

        <li class="nav-item mt-3 border-top border-secondary pt-3">
            <a class="nav-link text-white {{ request()->routeIs('admin.settings') ? 'bg-secondary rounded' : '' }}" 
               href="{{ route('admin.settings') }}">
                <i class="fas fa-cog me-2"></i> Pengaturan Website
            </a>
        </li>
    </ul>
</nav>