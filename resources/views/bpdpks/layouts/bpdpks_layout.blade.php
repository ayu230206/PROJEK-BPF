<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>BPDPKS — @yield('title', 'Dashboard')</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATATABLE -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- GLOBAL STYLE -->
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #2e59d9;
            --secondary: #f6c23e;
            --danger: #e74a3b;
            --success: #1cc88a;
            --neutral: #f5f6fa;
            --text-dark: #1f1f1f;
            --sidebar-bg: #ffffff;
        }

        body {
            background: var(--neutral);
            font-family: "Inter", sans-serif;
        }

        /* FIXED SIDEBAR */
        .sidebar-fixed {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid #e9ecef;
            padding: 25px 18px;
            box-shadow: 4px 0 14px rgba(0, 0, 0, 0.06);
            z-index: 100;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 40px 45px;
            min-height: 100vh;
        }

        /* GLOBAL CARD STYLE */
        .card-custom,
        .shadow-card {
            background: #fff;
            border-radius: 18px;
            padding: 25px;
            border: 1px solid #ececec;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-6px);
        }

        /* FIX ICON OVERFLOW */
        i.fas,
        i.fa {
            transform: none !important;
            position: unset !important;
        }
    </style>

    @include('bpdpks.layouts.style')
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar-fixed">
        @include('bpdpks.layouts.sidebar')
    </div>

    {{-- MAIN WRAPPER --}}
    <div class="content-wrapper">
        <main>
            @yield('content')
        </main>

        @include('bpdpks.layouts.footer')
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>

</html>