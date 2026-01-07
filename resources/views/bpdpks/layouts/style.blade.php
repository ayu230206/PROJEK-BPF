<style>
    /* ========================================================= */
    /* 1. VARIABEL & GLOBAL STYLES */
    /* ========================================================= */
    :root {
        --primary: #0b3a2e;
        /* Hijau Tua/Moss Green (Warna Dominan) */
        --accent: #bfa15a;
        /* Emas Kusam/Ochre (Warna Aksen) */
        --accent-light: #d8c491;
        /* Aksen Lebih Terang (Untuk teks/hover) */
        --text-color: #35423f;
        /* Teks Hitam Kehijauan */
        --background-light: #f4f7f6;
        /* Background Sangat Terang */
        --card-background: #ffffff;
        /* Background Kartu */
        --sidebar-width: 250px;
        /* Lebar Sidebar yang Konsisten */
        --logout-red: #e74a3b;
        /* Merah untuk Logout */
        --logout-hover: #cc0000;
        /* Merah Lebih Tua untuk Hover */
    }

    /* Global Reset & Body: DIKOREKSI: Menghapus display: flex dari body */
    body {
        background-color: var(--background-light);
        color: var(--text-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    /* ========================================================= */
    /* 2. SIDEBAR STYLES */
    /* ========================================================= */
    .sidebar {
        height: 100vh;
        width: var(--sidebar-width);
        position: fixed;
        top: 0;
        left: 0;
        background-color: var(--primary);
        color: #fff;
        padding: 20px 15px;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .sidebar-header {
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 20px;
    }

    .sidebar-header h4 {
        color: var(--accent-light);
        font-weight: 700;
        margin-bottom: 0;
        font-size: 1.3rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    .sidebar-menu-item {
        margin-bottom: 8px;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.2s, color 0.2s;
        font-size: 0.95rem;
    }

    .sidebar-menu-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .sidebar-menu-link.active {
        background-color: var(--accent);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar-menu-link i {
        margin-right: 12px;
        font-size: 1.1rem;
        min-width: 20px;
        text-align: center;
    }

    /* --- UPDATED: Sidebar Footer & Logout Button Merah dari awal --- */
    .sidebar-footer {
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }

    .logout-button {
        display: block;
        padding: 10px 15px;
        color: #fff;
        /* Teks putih */
        font-weight: 600;
        text-decoration: none;
        border: 2px solid var(--logout-red);
        border-radius: 8px;
        background-color: var(--logout-red);
        /* LANGSUNG MERAH */
        transition: background-color 0.2s, color 0.2s, border-color 0.2s;
        font-size: 0.95rem;
    }

    .logout-button:hover {
        background-color: var(--logout-hover);
        /* Merah lebih tua */
        color: #fff;
        border-color: var(--logout-hover);
    }

    .logout-button i {
        color: #fff !important;
    }

    /* ========================================================= */
    /* 3. MAIN CONTENT (Tidak berubah) */
    /* ========================================================= */
    .content-wrapper {
        margin-left: var(--sidebar-width) !important;
        width: calc(100% - var(--sidebar-width));
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        padding: 30px;
        flex-grow: 1;
    }

    /* ========================================================= */
    /* Ikon Fix (Tidak berubah) */
    /* ========================================================= */
    i.fas,
    i.fa {
        font-size: 1.5rem !important;
        position: initial !important;
        transform: none !important;
        max-width: 50px !important;
        max-height: 50px !important;
    }
</style>


<form id="bpdpks-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>