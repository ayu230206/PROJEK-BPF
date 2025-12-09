<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-2xl p-10 max-w-md w-full">
        <h1 class="text-2xl font-bold text-green-900 mb-6 text-center">Daftar Akun Mahasiswa</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('email') border-red-500 @enderror">
                @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Password</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('password') border-red-500 @enderror">
                @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
            </div>

            <!-- Role Hidden (Default Mahasiswa) -->
            <input type="hidden" name="role" value="mahasiswa">

            <!-- Pilihan Kampus (Dropdown) -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Asal Kampus</label>
                <select name="asal_kampus" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('asal_kampus') border-red-500 @enderror">
                    <option value="">-- Pilih Kampus --</option>
                    
                    {{-- PERBAIKAN DISINI: --}}
                    {{-- Pastikan controller mengirim variabel $kampus --}}
                    @foreach($kampus as $k)
                        {{-- Value menggunakan 'id', Tampilan menggunakan 'nama_kampus' --}}
                        <option value="{{ $k->id }}" {{ old('asal_kampus') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kampus }}
                        </option>
                    @endforeach

                </select>
                @error('asal_kampus') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Angkatan -->
            <div>
                <label class="block text-green-800 font-semibold mb-1">Angkatan</label>
                <input type="number" name="angkatan" value="{{ old('angkatan') }}" placeholder="Misal: 2024"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('angkatan') border-red-500 @enderror">
                @error('angkatan') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-green-800 text-white py-2 rounded-lg font-semibold hover:bg-green-900 transition-colors">
                Daftar
            </button>
        </form>

        <p class="mt-4 text-center text-green-700">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-green-900 font-semibold hover:underline">Login</a>
        </p>
    </div>
</body>

</html>