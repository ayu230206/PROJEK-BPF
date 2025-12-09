<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Beasiswa Sawit</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        /* Mengimport Font Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAF5;
        }

        /* --- Custom CSS untuk Admin Sawit --- */
        :root {
            --palm-green: #054D3F;
            --palm-gold: #FFC400;
            --sidebar-width: 260px;
        }

        /* 1. Sidebar Styling (Fixed Position) */
        .admin-sidebar {
            background-color: var(--palm-green);
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
        }

        /* 2. FIX LAYOUT: Margin Content agar tidak tertutup Sidebar */
        .content-shifted {
            margin-left: 0;
            transition: margin-left 0.3s;
        }

        @media (min-width: 768px) {
            .content-shifted {
                margin-left: var(--sidebar-width);
            }
        }
        
        /* 3. Navbar Styling */
        .navbar {
            background-color: var(--palm-green) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 101;
        }

        /* 4. Active Menu State */
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
            font-weight: bold;
            color: #FFC400 !important;
        }

        /* Gaya Lainnya */
        .text-sawit-utama { color: #0B795D; }
        .bg-sawit-utama { background-color: #0B795D; }
        .bg-sawit-highlight { background-color: #FFC400; }
        .text-sawit-highlight { color: #FFC400; }
        .card-stat {
            background-color: #FFFFFF;
            border-radius: 0.75rem;
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-2px);
        }

        /* --- STYLE BACKGROUND & OVERLAY --- */
        .konten-utama-bpdpks {
            background-image: url("{{ asset('img/sawit2.jpg') }}"); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            
            /* PERBAIKAN DI SINI: Ubah warna teks jadi Hitam/Gelap */
            color: #1f2937; /* Gray-800 Tailwind */
        }
        
        /* Overlay Putih Transparan (Whitewash) */
        .konten-utama-bpdpks::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            /* Putih dengan transparansi 85% */
            background-color: rgba(255, 255, 255, 0.85);
            z-index: 0;
            pointer-events: none;
        }

        /* Konten di atas overlay */
        .konten-sebenarnya {
            position: relative;
            z-index: 2;
        }

        /* Judul Halaman (Welcome) */
        .welcome {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--palm-green); /* Hijau Sawit Tua */
            margin-bottom: 0.5rem;
        }

        /* Subjudul (Subtle) */
        .subtle {
            font-size: 1rem;
            color: #4b5563; /* Abu-abu gelap */
            margin-bottom: 1.5rem;
        }

        /* Card Custom untuk Tabel */
        .card-custom {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

    </style>
    @yield('styles')
</head>
<body>

    @yield('body')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>