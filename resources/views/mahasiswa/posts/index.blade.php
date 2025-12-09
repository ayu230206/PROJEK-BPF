@extends('mahasiswa.layouts.app')

@section('content')
<div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen py-12 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-12">
            <div class="flex items-center">
                <svg class="w-10 h-10 text-green-700 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <h1 class="text-4xl font-extrabold text-green-900">Forum Mahasiswa</h1>
            </div>

            <a href="{{ route('mahasiswa.posts.create') }}"
                class="bg-gradient-to-r from-green-700 to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-800 hover:to-emerald-800 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Post Baru
            </a>
        </div>

        {{-- Daftar Post --}}
        <div class="space-y-8">

            @forelse ($posts as $post)
            <div
                class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl border border-white/20 hover:shadow-3xl hover:scale-102 transition-all duration-300">

                {{-- Header Post --}}
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $post->user->foto_profile 
                        ? asset('storage/'.$post->user->foto_profile) 
                        : asset('images/default-avatar.png') }}"
                        class="w-14 h-14 rounded-full object-cover border-2 border-green-400 shadow-md">
                    <div>
                        <p class="font-bold text-green-900 text-xl">{{ $post->user->nama_lengkap }}</p>
                        <p class="text-sm text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $post->tanggal_post->format('d M Y · H:i') }}
                        </p>
                    </div>
                </div>

                {{-- Isi --}}
                @if($post->isi)
                <p class="text-green-800 mb-6 text-lg whitespace-pre-line">{{ $post->isi }}</p>
                @endif

                {{-- Gambar --}}
                @if($post->gambar)
                <div class="rounded-xl border border-green-200 bg-gray-50 p-4 flex justify-center mb-6">
                    <img src="{{ asset('storage/' . $post->gambar) }}"
                        class="max-w-full max-h-[600px] object-contain rounded-lg shadow-lg">
                </div>
                @endif

                {{-- Footer --}}
                <div class="flex items-center gap-8 mt-6 text-sm text-green-700">

                    {{-- Komentar --}}
                    <a href="{{ route('mahasiswa.posts.show', $post->post_id) }}"
                        class="flex items-center gap-2 hover:text-green-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>{{ $post->comments->count() }} Komentar</span>
                    </a>

                    {{-- Like --}}
                    <button
                        class="flex items-center gap-2 hover:text-green-900 transition-colors duration-300 like-btn"
                        data-post-id="{{ $post->post_id }}">
                        <svg class="w-5 h-5 icon-like"
                            id="like-icon-{{ $post->post_id }}"
                            fill="{{ $post->likes->where('user_id', Auth::id())->count() ? 'currentColor' : 'none' }}"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                            </path>
                        </svg>

                        <span class="like-count" id="like-count-{{ $post->post_id }}">{{ $post->likes->count() }} Like</span>
                    </button>

                    {{-- Share --}}
                    <button type="button"
                        onclick="navigator.share({
                            title: 'Forum Mahasiswa',
                            text: '{{ Str::limit($post->isi, 50) }}',
                            url: '{{ route('mahasiswa.posts.show', $post->post_id) }}'
                        })"
                        class="flex items-center gap-2 hover:text-green-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                            </path>
                        </svg>
                        Share
                    </button>

                </div>
            </div>
            @empty

            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                <p class="text-xl text-gray-500">Belum ada post di forum.</p>
            </div>

            @endforelse
        </div>
    </div>
</div>

{{-- LIKE/UNLIKE SCRIPT FINAL --}}
<script>
    // helper: route template (menggunakan named route supaya pasti tepat)
    const likeRouteTemplate = "{{ route('mahasiswa.posts.like.toggle', ['id' => ':POST_ID']) }}";

    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async function() {

            const postId = this.dataset.postId;
            const url = likeRouteTemplate.replace(':POST_ID', postId);

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                });

                // jika bukan OK -> keluarkan warning di console
                if (!res.ok) {
                    console.warn("Like request failed:", res.status, res.statusText);
                    return;
                }

                const data = await res.json();

                // validasi data
                if (typeof data.likes_count === "undefined") {
                    console.warn("Unexpected response:", data);
                    return;
                }

                // update UI: jumlah like
                const countEl = document.getElementById(`like-count-${postId}`);
                if (countEl) countEl.textContent = data.likes_count + " Like";

                // update UI: icon fill (jadi penuh ketika liked)
                const icon = document.getElementById(`like-icon-${postId}`);
                if (icon) {
                    icon.setAttribute('fill', data.liked ? 'currentColor' : 'none');
                }

            } catch (err) {
                console.error("Gagal request like:", err);
            }

        });
    });
</script>

@endsection
