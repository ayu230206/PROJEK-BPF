@extends('mahasiswa.layouts.app')
@section('content')
<div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white/80 backdrop-blur-lg p-10 rounded-2xl shadow-2xl border border-white/20 hover:shadow-3xl transition-all duration-300">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-green-900 mb-2">Buat Post Baru</h1>
                <p class="text-lg text-green-700">Bagikan pemikiran Anda di forum mahasiswa</p>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-800 px-6 py-4 rounded-xl mb-6 shadow-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('mahasiswa.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-8">
                    <label class="block text-green-800 font-semibold mb-3 text-lg">Isi Post</label>
                    <textarea name="isi" rows="5" class="w-full border-2 border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400 resize-none" required>{{ old('isi') }}</textarea>
                </div>
                <div class="mb-8">
                    <label class="block text-green-800 font-semibold mb-3 text-lg">Gambar (opsional)</label>
                    <input type="file" id="imageInput" name="gambar" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-colors duration-300">
                </div>
                <div class="mb-8 flex justify-center">
                    <img id="preview" class="hidden w-64 h-64 object-cover rounded-xl border-2 border-green-300 shadow-lg hover:shadow-xl transition-shadow duration-300">
                </div>
                <div class="flex justify-end gap-4">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="px-6 py-3 rounded-xl bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:from-green-700 hover:to-emerald-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('imageInput').addEventListener('change', function() {
    const preview = document.getElementById('preview');
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
