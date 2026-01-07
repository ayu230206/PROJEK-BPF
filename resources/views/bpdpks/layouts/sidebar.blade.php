<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-seedling me-2"></i>BPDPKS Admin</h4>
        <small style="color: rgba(255, 255, 255, 0.6);">Sistem Monitoring Beasiswa</small>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.dashboard') }}" class="sidebar-menu-link active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.keuangan.index') }}" class="sidebar-menu-link">
                <i class="fas fa-wallet"></i> Informasi Keuangan
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.kerjasama.index') }}" class="sidebar-menu-link">
                <i class="fas fa-university"></i> Kampus & Kerjasama
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.lowongan.index') }}" class="sidebar-menu-link">
                <i class="fas fa-bullhorn"></i> Lowongan Kerja
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.datamahasiswa.index') }}" class="sidebar-menu-link">
                <i class="fas fa-user-graduate"></i> Data Mahasiswa
            </a>
        </li>



        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.feedback.index') }}" class="sidebar-menu-link">
                <i class="fas fa-comment-dots"></i> Feedback Mahasiswa
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-button"
            onclick="event.preventDefault(); document.getElementById('bpdpks-logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i> Keluar (Logout)
        </a>
    </div>
</div>