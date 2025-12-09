<div class="sidebar">
<div class="sidebar-header">
<h4><i class="fas fa-user-shield me-2 text-warning"></i>Admin Pusat</h4>
<small style="color: rgba(255, 255, 255, 0.6);">Sistem Monitoring & Kontrol</small>
</div>

<ul class="sidebar-menu list-unstyled">
    <li class="sidebar-menu-item">
        {{-- Contoh rute dashboard admin --}}
        <a href="{{ route('admin.dashboard') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="sidebar-menu-item mt-3">
        <h6 class="text-white-50 ms-3">Manajemen Mahasiswa</h6>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.mahasiswa.data.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/mahasiswa/data*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Data Mahasiswa
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.mahasiswa.akademik.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/akademik*') ? 'active' : '' }}">
            <i class="fas fa-graduation-cap"></i> Nilai Akademik (IPS/IPK)
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.mahasiswa.dokumen.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/mahasiswa/dokumen*') ? 'active' : '' }}">
            <i class="fas fa-file-check"></i> Verifikasi Dokumen
        </a>
    </li>

    <li class="sidebar-menu-item mt-3">
        <h6 class="text-white-50 ms-3">Konten & Program</h6>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.beasiswa.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/beasiswa/program*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Program Beasiswa (CRUD)
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.penelitian-lomba.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/penelitian*') ? 'active' : '' }}">
            <i class="fas fa-flask"></i> Penelitian & Lomba (CRUD)
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.notifikasi.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/notifikasi*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i> Pengumuman & Notifikasi
        </a>
    </li>

    <li class="sidebar-menu-item mt-3">
        <h6 class="text-white-50 ms-3">Data Bersama (BPDPKS)</h6>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.lowongan.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/lowongan*') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> Magang & Lowongan
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.keuangan.index') ?? '#' }}" class="sidebar-menu-link {{ Request::is('admin/keuangan*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i> Data Keuangan
        </a>
    </li>
</ul>

{{-- Footer is now outside the sidebar (in LayoutAdmin) but here's the user info --}}
<div class="sidebar-footer position-absolute bottom-0 start-0 w-100 p-3">
    <small>Logged in as: <br>
    <strong class="text-warning">{{ Auth::user()->nama_lengkap ?? 'Admin User' }}</strong></small>
</div>


</div>