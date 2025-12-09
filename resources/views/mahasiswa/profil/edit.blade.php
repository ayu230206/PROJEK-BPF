{{-- resources/views/admin/mahasiswa/profil/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-green-100 min-h-screen flex">

    <main class="flex-1 p-10 max-w-4xl mx-auto bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 my-12 hover:shadow-3xl transition-all duration-300">
    <div class="text-center mb-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Foto Profil --}}
        <div class="mb-8" 
            x-data="{ fotoPreview: '{{ $user->foto_profile ? asset("storage/".$user->foto_profile) : asset("images/default-avatar.png") }}' }">
            
            <label class="block text-green-800 mb-3 font-semibold text-lg">Foto Profil</label>
            
            <div class="flex justify-center mb-4">
                <img :src="fotoPreview" 
                     class="w-32 h-32 rounded-full object-cover border-4 border-green-600 shadow-lg hover:scale-105 transition-transform duration-300">
            </div>

            <input type="file" 
                   name="foto_profile" 
                   @change="fotoPreview = URL.createObjectURL($event.target.files[0])" 
                   class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-colors duration-300">
        </div>

        {{-- Nama Lengkap --}}
        <div class="mb-6">
            <label class="block text-green-800 mb-3 font-semibold text-lg">Nama Lengkap</label>
            <input type="text" name="nama_lengkap"
                   value="{{ $user->nama_lengkap }}"
                   class="border-2 border-gray-200 p-4 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400">
        </div>

        {{-- Email --}}
        <div class="mb-6">
            <label class="block text-green-800 mb-3 font-semibold text-lg">Email</label>
            <input type="email" name="email"
                   value="{{ $user->email }}"
                   class="border-2 border-gray-200 p-4 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400">
        </div>

        {{-- Bio --}}
        <div class="mb-8">
            <label class="block text-green-800 mb-3 font-semibold text-lg">Bio</label>
            <textarea name="bio"
                      class="border-2 border-gray-200 p-4 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400 resize-none"
                      rows="4">{{ $user->bio }}</textarea>
        </div>

        {{-- ✅ TOMBOL AKSI (SUDAH DIPERBAIKI) --}}
        <div class="mt-8 flex gap-6 justify-center">

            {{-- Tombol Update --}}
            <button type="submit"
                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Profil
            </button>

            {{-- Tombol Kembali --}}
            <a href="{{ route('mahasiswa.profil.index') }}"
               class="border-2 border-green-600 text-green-700 px-8 py-4 rounded-xl font-semibold hover:bg-green-50 hover:border-green-700 hover:text-green-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
               Kembali ke Dashboard
            </a>

        </div>

    </form>

</main>
</body>
</html>
