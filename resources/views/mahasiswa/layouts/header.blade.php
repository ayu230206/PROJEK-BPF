<header class="bg-gradient-to-r from-green-900 to-green-800 text-white px-8 py-5 shadow-2xl flex justify-between items-center backdrop-blur-sm border-b border-green-700/50">
    <h1 class="text-3xl font-extrabold tracking-wide">Sistem Informasi Beasiswa Sawit</h1>
    <div class="flex items-center gap-6">
        <span class="hidden md:block text-lg font-medium">{{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}</span>
        <img src="{{ Auth::user()->foto_profile ? asset('storage/'.Auth::user()->foto_profile) : asset('images/default-avatar.png') }}"
             class="w-12 h-12 rounded-full border-2 border-green-600 object-cover hover:ring-4 hover:ring-green-500 transition-all duration-300 hover:scale-110 shadow-lg">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                onclick="return confirm('Yakin ingin logout?')"
                class="bg-gradient-to-r from-red-600 to-red-700 px-5 py-2 rounded-xl text-white font-semibold hover:from-red-700 hover:to-red-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</header>