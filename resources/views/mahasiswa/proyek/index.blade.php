@extends('mahasiswa.layouts.app')
@section('title', 'Proyek Akhir')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

    {{-- Alert --}}
    @if(session('success'))

    <div class="mb-4 p-3 rounded bg-green-600 text-white text-center shadow">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tombol Kembali ke Menu Proyek Akhir --}}

    <div class="mb-6">
        <a href="{{ route('mahasiswa.proyek.dashboard') }}"
            class="inline-flex items-center gap-2 bg-white px-5 py-2 rounded-xl shadow border border-green-300 text-green-900 font-semibold hover:bg-green-100 hover:shadow-md transition">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>

            Kembali ke Menu Proyek


        </a>

    </div>

    {{-- Form Tambah Proyek Akhir --}}

    <div class="bg-white rounded-2xl shadow-lg border border-green-700 mb-6">
        <div class="px-6 py-3 bg-green-800 text-white font-semibold rounded-t-2xl">
            Tambah Proyek Akhir
        </div>
        <div class="p-6">
            <form action="{{ route('mahasiswa.proyek.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="font-semibold">Judul Proyek</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="font-semibold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                    </div>
                    <div class="mb-4">
                        <label class="font-semibold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Pembimbing</label>
                    <input type="text" name="pembimbing" value="{{ old('pembimbing') }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Status Proyek</label>
                    <select name="status_proyek" class="w-full rounded-lg border p-2 mt-1">
                        <option value="pending">Draft</option>
                        <option value="on_progress">Sedang Berjalan</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label class="font-semibold">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1" placeholder="2025">
                </div>

                <button class="bg-green-700 hover:bg-green-900 text-white px-5 py-2 rounded-lg mt-5 shadow font-semibold transition">
                    Tambah Proyek
                </button>
            </form>


        </div>

    </div>

    {{-- Tabel Riwayat Proyek Akhir --}}

    <div class="bg-white rounded-2xl shadow-lg border border-green-700 mb-8">
        <div class="px-6 py-3 bg-green-800 text-white font-semibold rounded-t-2xl">
            Riwayat Proyek Akhir
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="w-full border text-sm text-left">
                <thead>
                    <tr class="bg-green-700 text-white">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Judul</th>
                        <th class="p-3 border">Pembimbing</th>
                        <th class="p-3 border text-center">Status</th>
                        <th class="p-3 border">Tahun</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                    <tr class="hover:bg-green-100 transition">
                        <td class="p-3 border">{{ $loop->iteration }}</td>
                        <td class="p-3 border font-semibold">
                            {{ $project->judul }}
                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($project->deskripsi, 50) }}</p>
                        </td>
                        <td class="p-3 border">{{ $project->pembimbing ?? '-' }}</td>
                        <td class="p-3 border text-center capitalize">
                            @if($project->status_proyek == 'pending')
                            <span class="bg-gray-500 text-white px-3 py-1 rounded shadow text-xs">Draft</span>
                            @elseif($project->status_proyek == 'on_progress')
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded shadow text-xs">Berjalan</span>
                            @else
                            <span class="bg-green-600 text-white px-3 py-1 rounded shadow text-xs">Selesai</span>
                            @endif
                        </td>
                        <td class="p-3 border">{{ $project->tahun ?? '-' }}</td>
                        <td class="p-3 border flex justify-center gap-2">

                            {{-- Tombol Edit --}}
                            <a href="{{ route('mahasiswa.proyek.edit', $project->proyek_id) }}" class="bg-blue-600 text-white px-3 py-1 rounded shadow hover:bg-blue-800 transition text-xs">Edit</a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('mahasiswa.proyek.destroy', $project->proyek_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-800 transition text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-3 border text-gray-500 text-center">Belum ada proyek akhir yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>

    </div>

</div>
@endsection