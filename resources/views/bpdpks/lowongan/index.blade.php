@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Manajemen Lowongan & Magang')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Kelas Tailwind) ===================== --}}
    <div
        class="flex items-center justify-between bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-bullhorn me-2"></i> Manajemen Lowongan & Magang
            </h1>
            <p class="text-sm opacity-85 mt-1">Kelola daftar lowongan kerja dan kesempatan magang untuk mahasiswa beasiswa.
            </p>
        </div>

        {{-- Tombol utama diubah menjadi warna hijau --}}
        <a href="{{ route('bpdpks.lowongan.create') }}"
            class="btn inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-xl shadow-md transition duration-200">
            <i class="fas fa-plus me-1"></i> Tambah Lowongan / Magang
        </a>
    </div>

    {{-- ===================== ALERT SUCCESS (Kelas Bootstrap) ===================== --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===================== CARD FILTER (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100 mb-6">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-filter me-2 text-green-700"></i>
            Filter Data</h5>
        <form action="{{ route('bpdpks.lowongan.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label text-sm font-medium text-gray-700">Cari Judul Lowongan</label>
                {{-- Menggunakan form-control Bootstrap --}}
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Judul Lowongan/Magang">
            </div>
            <div class="col-md-3">
                <label for="tipe_filter" class="form-label text-sm font-medium text-gray-700">Tipe</label>
                {{-- Menggunakan form-select Bootstrap --}}
                <select class="form-select" id="tipe_filter" name="tipe">
                    <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="magang" {{ request('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                    <option value="lowongan_kerja" {{ request('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja
                    </option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{-- Tombol Filter diubah ke warna hijau --}}
                <button type="submit" class="btn btn-primary bg-green-600 hover:bg-green-700 text-white me-2">
                    <i class="fas fa-search me-1"></i> Terapkan Filter
                </button>
                <a href="{{ route('bpdpks.lowongan.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-600">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ===================== ALERT PENDING APLIKASI (Kelas Bootstrap) ===================== --}}
    @if ($pendingAplikasiCount > 0)
        <div class="alert alert-warning mb-4 rounded-xl border-l-4 border-yellow-500 bg-yellow-100 text-yellow-800 p-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Ada <strong>{{ $pendingAplikasiCount }}</strong> aplikasi magang/lowongan yang <strong>perlu ditinjau!</strong>
        </div>
    @endif


    {{-- ===================== CARD DAFTAR LOWONGAN (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-list me-2 text-green-700"></i>
            Daftar Lowongan & Magang</h5>
        <div class="table-responsive">
            <table class="table table-hover datatable" id="lowonganTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Deadline</th>
                        <th>Pelamar</th>
                        <th>Diinput Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $lowongan)
                        <tr>
                            <td>{{ $loop->iteration + ($lowongans->perPage() * ($lowongans->currentPage() - 1)) }}</td>
                            <td>{{ $lowongan->judul }}</td>
                            <td>{!! $lowongan->getTipeBadge() !!}</td>
                            <td>{{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : 'Tidak Ada' }}
                            </td>
                            <td>
                                {{-- Tombol Pelamar diubah ke warna hijau outline --}}
                                <a href="{{ route('bpdpks.lowongan.monitoring', $lowongan->id) }}"
                                    class="btn btn-sm btn-outline-success border-2">
                                    <i class="fas fa-users me-1"></i> {{ $lowongan->aplikasi_count }} Pelamar
                                </a>
                            </td>
                            <td>{{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin' }}</td>

                            <td>
                                {{-- Tombol Edit diubah menggunakan warna kuning Tailwind --}}
                                <a href="{{ route('bpdpks.lowongan.edit', $lowongan->id) }}"
                                    class="btn btn-sm text-white bg-yellow-500 hover:bg-yellow-600 me-1" title="Edit Lowongan">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>

                                {{-- Tombol Hapus diubah menggunakan warna merah Tailwind --}}
                                <form action="{{ route('bpdpks.lowongan.destroy', $lowongan->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Menghapus akan menghapus semua aplikasi yang masuk.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-white bg-red-600 hover:bg-red-700"
                                        title="Hapus Lowongan">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada lowongan atau magang yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{-- Pagination (Menggunakan template Bootstrap Laravel) --}}
            {{ $lowongans->links() }}
        </div>
    </div>

@endsection