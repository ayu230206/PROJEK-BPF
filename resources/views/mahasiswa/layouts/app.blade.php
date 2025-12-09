<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Informasi Beasiswa Sawit' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    @include('mahasiswa.layouts.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- ✅ HEADER --}}
    @include('mahasiswa.layouts.header')

    {{-- ✅ WRAPPER SIDEBAR + KONTEN --}}
    <div class="flex flex-1">

        {{-- ✅ SIDEBAR --}}
        @include('mahasiswa.layouts.sidebar')

        {{-- ✅ KONTEN UTAMA (sudah diperbaiki) --}}
        <main class="flex-1 p-6 md:p-10 pb-24">
            @yield('content')
        </main>

    </div>

    {{-- ✅ FOOTER --}}
    @include('mahasiswa.layouts.footer')


    {{-- ✅ SCRIPT COPY LINK SHARE (WA, DLL) --}}
    <script>
        function copyLink(link) {
            navigator.clipboard.writeText(link).then(() => {
                alert("Link berhasil disalin!");
            }).catch(() => {
                alert("Gagal menyalin link");
            });
        }
    </script>

</body>
</html>
