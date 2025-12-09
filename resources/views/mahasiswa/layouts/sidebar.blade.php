<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed md:static z-40 md:translate-x-0 w-64 bg-gradient-to-b from-green-800 to-green-900 text-green-100 min-h-screen p-6 shadow-2xl transition-all duration-300 ease-in-out">

    <nav class="flex flex-col gap-4">

        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('mahasiswa.posts.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="font-medium">Forum</span>
        </a>

        <a href="{{ route('mahasiswa.profil.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="font-medium">Profil</span>
        </a>

        <a href="{{ route('mahasiswa.akademik.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="font-medium">Akademik</span>
        </a>

        <a href="{{ route('mahasiswa.proyek.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <span class="font-medium">Proyek Akhir</span>
        </a>

        <a href="{{ route('mahasiswa.magang.lowongan') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8m0 0V4"></path>
            </svg>
            <span class="font-medium">Magang</span>
        </a>

        <a href="{{ route('mahasiswa.lowongankerja.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="font-medium">Lowongan Kerja</span>
        </a>
    

        <a href="{{ route('mahasiswa.feedback.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg hover:scale-105 transition-all duration-300 group">
            <svg class="w-6 h-6 mr-3 group-hover:text-green-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M9 4h6a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
            </svg>
            <span class="font-medium">Feedback</span>
        </a>
        <a href="{{ route('mahasiswa.notifikasi') }}" class="relative flex items-center px-4 py-3 rounded-xl hover:bg-green-700/80 hover:shadow-lg transition-all">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405
                    A2.032 2.032 0 0118 14.158V11
                    a6.002 6.002 0 00-4-5.659V5
                    a2 2 0 10-4 0v.341
                    C7.67 6.165 6 8.388 6 11v3.159
                    c0 .538-.214 1.055-.595 1.436
                    L4 17h5m6 0v1
                    a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            <span class="font-medium">Notifikasi</span>

            @if(auth()->user()->unreadNotifications->count() > 0)
            <span style="
            position:absolute;
            top:6px;
            right:10px;
            background:red;
            color:white;
            font-size:12px;
            font-weight:bold;
            padding:2px 6px;
            border-radius:999px;">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
            @endif
        </a>
    </nav>
</aside>