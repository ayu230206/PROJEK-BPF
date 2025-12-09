<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-2xl p-10 max-w-md w-full">
        <h1 class="text-2xl font-bold text-green-900 mb-6 text-center">Login Akun</h1>

        @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-green-800 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('email') border-red-500 @enderror">
                @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-green-800 font-semibold mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 @error('password') border-red-500 @enderror">
                @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-green-800 focus:ring-green-700 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-green-900">
                        Ingat Saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                <a class="text-sm text-green-700 hover:underline hover:text-green-900" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-green-800 text-white py-2 rounded-lg font-semibold hover:bg-green-900 transition-colors">
                Login
            </button>
            <!-- TOMBOL LOGIN GOOGLE -->
            <a href="{{ route('google.redirect') }}"
                class="w-full mt-4 inline-block bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors text-center">
                <svg class="inline-block w-5 h-5 mr-2 -mt-1" viewBox="0 0 533.5 544.3">
                    <path fill="#4285F4" d="M533.5 278.4c0-17.8-1.6-35.1-4.6-51.8H272v97.9h146.9c-6.3 34-25.1 62.8-53.5 82v68h86.5c50.5-46.5 79.6-115 79.6-196.1z" />
                    <path fill="#34A853" d="M272 544.3c72.6 0 133.6-24 178.2-65.2l-86.5-68c-24 16-54.6 25.5-91.7 25.5-70.5 0-130.3-47.5-151.5-111.3h-89v69.9c44.6 87.9 135.8 150.1 240.5 150.1z" />
                    <path fill="#FBBC05" d="M120.8 318.3c-10.5-31.1-10.5-64.9 0-96l-89-69.9C5.3 214.7 0 242.8 0 272c0 29.2 5.3 57.3 31.8 119.6l89-69.3z" />
                    <path fill="#EA4335" d="M272 107.7c37.2 0 70.5 12.8 96.9 37.8l72.7-72.7C405.6 25.5 344.6 0 272 0 167.3 0 76.1 62.2 31.5 150.1l89 69.9C141.7 155.2 201.5 107.7 272 107.7z" />
                </svg>
                Login dengan Google
            </a>

        </form>

        <p class="mt-4 text-center text-green-700">
            Belum punya akun? <a href="{{ route('register') }}" class="text-green-900 font-semibold hover:underline">Daftar</a>
        </p>
    </div>
</body>

</html>