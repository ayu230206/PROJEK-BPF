@extends('mahasiswa.layouts.app')
@section('title', 'Edit Proyek Akhir')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-6">

<h2 class="text-3xl font-bold mb-6 text-green-900">Edit Proyek Akhir: {{ $proj->judul }}</h2>

{{-- Tombol Kembali --}}
<div class="mb-6">
    <a href="{{ route('mahasiswa.proyek.index') }}" 
       class="inline-flex items-center gap-2 bg-white px-5 py-2 rounded-xl shadow border border-green-300 text-green-900 font-semibold hover:bg-green-100 transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
        Kembali ke Riwayat
    </a>
</div>

{{-- Form Edit Proyek Akhir --}}
<div class="bg-white rounded-2xl shadow-lg border border-green-700">
    <div class="px-6 py-3 bg-green-800 text-white font-semibold rounded-t-2xl">
        Perbarui Data Proyek
    </div>
    <div class="p-6">
        {{-- Action mengarah ke route update dengan ID proyek --}}
        <form action="{{ route('mahasiswa.proyek.update', $proj->proyek_id) }}" method="POST">
            @csrf
            @method('PUT') 

            {{-- Judul Proyek --}}
            <div class="mb-4">
                <label class="font-semibold">Judul Proyek</label>
                <input type="text" name="judul" value="{{ old('judul', $proj->judul) }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="font-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">{{ old('deskripsi', $proj->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tanggal Mulai --}}
                <div class="mb-4">
                    <label class="font-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $proj->tanggal_mulai) }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                </div>
                {{-- Tanggal Selesai --}}
                <div class="mb-4">
                    <label class="font-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $proj->tanggal_selesai) }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                </div>
            </div>

            {{-- Pembimbing --}}
            <div class="mb-4">
                <label class="font-semibold">Pembimbing</label>
                <input type="text" name="pembimbing" value="{{ old('pembimbing', $proj->pembimbing) }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
            </div>

            {{-- Status Proyek --}}
            <div class="mb-4">
                <label class="font-semibold">Status Proyek</label>
                <select name="status_proyek" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1">
                    <option value="pending" {{ old('status_proyek', $proj->status_proyek) == 'pending' ? 'selected' : '' }}>Draft</option>
                    <option value="on_progress" {{ old('status_proyek', $proj->status_proyek) == 'on_progress' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="completed" {{ old('status_proyek', $proj->status_proyek) == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label class="font-semibold">Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', $proj->tahun) }}" class="w-full rounded-lg border border-green-400 focus:ring-green-600 p-2 mt-1" placeholder="2025">
            </div>

            <button class="bg-blue-600 hover:bg-blue-800 text-white px-5 py-2 rounded-lg mt-5 shadow font-semibold transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>


</div>
@endsection