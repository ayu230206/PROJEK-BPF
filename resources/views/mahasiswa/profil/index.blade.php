@extends('mahasiswa.layouts.app')

@section('content')
<div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen py-12 px-6">
    <div class="max-w-5xl mx-auto">
        {{-- Kartu Profil --}}
        <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl border border-white/20 mb-12 hover:shadow-3xl transition-all duration-300">
            <div class="flex items-center gap-8">
                <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : asset('images/default-avatar.png') }}"
                     class="w-28 h-28 rounded-full object-cover border-4 border-green-600 shadow-lg hover:scale-105 transition-transform duration-300">

                <div class="flex-1">
                    <h2 class="text-3xl font-bold text-green-900 mb-2">{{ $user->nama_lengkap }}</h2>
                    <p class="text-green-700 text-lg mb-2">{{ $user->email }}</p>
                    <p class="text-green-800 text-base">{{ $user->bio ?? 'Belum ada bio.' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('mahasiswa.profil.edit') }}"
                   class="inline-flex items-center bg-gradient-to-r from-green-700 to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-800 hover:to-emerald-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>

        {{-- Riwayat Postingan --}}
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 text-green-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h2 class="text-3xl font-bold text-green-900">Riwayat Postingan Saya</h2>
            </div>

            @if($posts->count() > 0)
                <div class="space-y-8">
                    @foreach ($posts as $post)
                        <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl border border-white/20 relative hover:shadow-3xl hover:scale-102 transition-all duration-300">

                            {{-- Header --}}
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-green-600 text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Dipost pada: {{ $post->tanggal_post->format('d M Y · H:i') }}
                                </p>

                                {{-- BUTTON HAPUS LANGSUNG (TANPA TITIK 3) --}}
                                <form action="{{ route('mahasiswa.posts.destroy', $post->post_id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="flex items-center gap-1 px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-300">

                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>

                                        Hapus
                                    </button>
                                </form>

                            </div>

                            {{-- Isi --}}
                            <p class="text-green-900 mb-4 whitespace-pre-line text-lg leading-relaxed">
                                {{ $post->isi }}
                            </p>

                            {{-- Gambar Ditengah & Responsif --}}
                            @if($post->gambar)
                                <div class="flex justify-center mt-6">
                                    <img src="{{ asset('storage/' . $post->gambar) }}"
                                         class="max-w-full md:max-w-2xl h-auto rounded-xl border shadow-lg hover:shadow-xl transition-shadow duration-300">
                                </div>
                            @endif

                            {{-- Footer: Komentar, Like, Share --}}
                            <div class="flex items-center gap-8 mt-6 text-sm text-green-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    {{ $post->comments->count() }} Komentar
                                </span>

                                <span class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                    </svg>
                                    {{ $post->likes->count() }} Like
                                </span>

                                {{-- Tombol Share --}}
                                <a href="#"
                                   onclick="navigator.share({
                                       title: 'Postingan Mahasiswa',
                                       text: '{{ \Illuminate\Support\Str::limit($post->isi, 50) }}',
                                       url: '{{ url()->current() }}'
                                   })"
                                   class="flex items-center gap-1 hover:text-green-900 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <p class="text-xl text-gray-500">Belum ada postingan.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
