@extends('mahasiswa.layouts.app')

@section('title', 'Informasi Lomba')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-green-800">
        🎯 Informasi Lomba Terbaru
    </h1>

    {{-- 🔍 Form Pencarian --}}
    <form method="GET" action="{{ route('mahasiswa.info-lomba') }}" class="mb-6">
        <input 
            type="text" 
            name="q" 
            placeholder="Cari lomba berdasarkan judul, penyelenggara, atau deskripsi..."
            value="{{ request('q') }}"
            class="w-full p-3 border rounded-lg shadow-sm focus:ring focus:ring-green-200"
        >
    </form>

    @if($lombas->count() == 0)
        <div class="bg-green-100 text-green-800 p-4 rounded">
            Belum ada informasi lomba yang tersedia.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($lombas as $lomba)
                <div class="bg-white rounded-lg shadow p-5 border border-green-200">
                    <h2 class="text-xl font-semibold text-green-800 mb-2">
                        {{ $lomba->judul }}
                    </h2>

                    <p class="text-sm text-green-600 mb-2">
                        <b>Penyelenggara:</b> {{ $lomba->penyelenggara ?? '-' }}
                    </p>

                    <p class="text-sm text-green-600 mb-2">
                        <b>Deskripsi:</b><br>
                        {{ $lomba->deskripsi ?? '-' }}
                    </p>

                    <div class="text-sm text-green-600 mb-2">
                        <b>Tanggal:</b>
                        {{ $lomba->tanggal_mulai ?? '-' }}
                        s/d
                        {{ $lomba->tanggal_berakhir ?? '-' }}
                    </div>

                    @if($lomba->link_pendaftaran)
                        <a href="{{ $lomba->link_pendaftaran }}"
                           target="_blank"
                           class="inline-block mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Daftar Sekarang
                        </a>
                    @else
                        <span class="inline-block mt-3 bg-green-400 text-white px-4 py-2 rounded">
                            Info Internal Kampus
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
