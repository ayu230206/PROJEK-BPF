@extends('mahasiswa.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">

    {{-- Judul Post --}}
    <h1 class="text-3xl font-bold mb-4">Post Mahasiswa</h1>

    {{-- Informasi Penulis dan Tanggal --}}
    <p class="text-gray-600 mb-4">
        Oleh: <strong>{{ $post->user->nama_lengkap }}</strong> |
        Diposting pada: {{ $post->tanggal_post->format('d M Y, H:i') }}
    </p>

    {{-- Konten Post --}}
    <div class="mb-6">
        <p class="text-gray-800">{{ $post->isi }}</p>

        @if($post->gambar)
            <img src="{{ asset('storage/' . $post->gambar) }}" 
                 alt="Gambar Post" 
                 class="w-full rounded-lg mt-4">
        @endif
    </div>

    {{-- Likes --}}
    <div class="mb-6">
        <span class="text-red-500 font-semibold">❤️ {{ $post->likes->count() }} Likes</span>
    </div>

    {{-- Form Komentar --}}
    <div class="mb-6">
        <form action="{{ route('mahasiswa.posts.comment.store', $post->post_id) }}" method="POST">
            @csrf
            <div class="flex items-center space-x-2">
                <input type="text" name="komentar" placeholder="Tulis komentar..." 
                       class="flex-1 border rounded px-3 py-2" required>
                <button type="submit" 
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Kirim
                </button>
            </div>
        </form>
    </div>

    {{-- Komentar --}}
    <div>
        <h3 class="text-xl font-semibold mb-2">
            Komentar ({{ $post->comments->count() }})
        </h3>

        @if($post->comments->count() > 0)
            <ul class="space-y-3">
                @foreach($post->comments as $comment)
                    <li class="p-3 bg-gray-100 rounded flex items-start space-x-3">

                        {{-- ✅ FOTO PROFIL SESUAI DATABASE --}}
                        @if($comment->user->foto_profile)
                            <img src="{{ asset('storage/' . $comment->user->foto_profile) }}" 
                                 class="w-8 h-8 rounded-full object-cover">
                        @else
                            <img src="{{ asset('images/default.png') }}" 
                                 class="w-8 h-8 rounded-full object-cover">
                        @endif

                        <div>
                            <p class="font-semibold">{{ $comment->user->nama_lengkap }}</p>
                            <p>{{ $comment->komentar }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ $comment->tanggal_comment->diffForHumans() }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada komentar.</p>
        @endif
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-6">
        <a href="{{ route('mahasiswa.posts.index') }}" 
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Kembali
        </a>
    </div>

</div>
@endsection
