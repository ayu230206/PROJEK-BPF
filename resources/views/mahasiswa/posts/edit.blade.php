{{-- resources/views/mahasiswa/posts/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 min-h-screen flex justify-center items-start pt-10">
    <div class="bg-white p-6 rounded-lg shadow w-full max-w-xl">
        <h1 class="text-2xl font-bold text-green-900 mb-4">Edit Post</h1>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('posts.update', $post->post_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-green-800 font-semibold mb-2">Isi Post</label>
                <textarea name="isi" rows="4" class="w-full border border-green-300 rounded p-2" required>{{ old('isi', $post->isi) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-green-800 font-semibold mb-2">Gambar (opsional)</label>
                @if($post->gambar)
                    <img src="{{ asset('storage/'.$post->gambar) }}" class="mb-2 rounded w-48" alt="Gambar Post">
                @endif
                <input type="file" name="gambar" accept="image/*" class="w-full">
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</a>
                <button type="submit" class="px-4 py-2 rounded bg-green-800 text-white hover:bg-green-900">Simpan</button>
            </div>
        </form>
    </div>

</body>
</html>
