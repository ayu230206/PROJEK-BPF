@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Kampus & Kerjasama')

@section('content')


    {{-- ===================== HEADER MODERN (Sesuai Request Warna Hijau Gelap) ===================== --}}
    {{-- Menggunakan Tailwind untuk styling header luar (sesuai permintaan) --}}
    <div
        class="flex justify-between items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-university me-2"></i> Data Kampus & Kerjasama
            </h1>
            <p class="text-sm opacity-85 mt-1">Manajemen daftar universitas dan status kerjasama dengan BPDPKS.</p>
        </div>
        {{-- Tombol Tambah: Menggunakan warna hijau yang lebih gelap --}}
        <a href="{{ route('bpdpks.kerjasama.create') }}"
            class="px-5 py-3 text-sm font-semibold rounded-xl transition duration-200 ease-in-out 
                 bg-green-800 border border-green-800 hover:bg-green-900 text-white shadow-lg shadow-green-700/50 hover:scale-[1.02]">
            <i class="fas fa-plus me-1"></i> Tambah Kampus
        </a>
    </div>

    {{-- ===================== ALERTS (Menggunakan Kelas Bootstrap Asli) ===================== --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===================== FILTER DATA KAMPUS (Custom Card, Fungsionalitas Bootstrap) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100 mb-8">
        <h5 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            {{-- ICON DIUBAH WARNANYA DARI text-blue-600 menjadi text-green-600 --}}
            <i class="fas fa-filter me-3 text-green-600"></i> Filter Data Kampus
        </h5>

        <form action="{{ route('bpdpks.kerjasama.index') }}" method="GET" class="row g-3">
            {{-- Menggunakan kelas Bootstrap Grid untuk konsistensi --}}
            <div class="col-md-5">
                <label for="search" class="form-label">Cari Nama/Kode Kampus</label>
                {{-- Menggunakan form-control Bootstrap --}}
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Nama atau Kode Kampus">
            </div>
            <div class="col-md-3">
                <label for="status_aktif" class="form-label">Status Kerjasama</label>
                {{-- Menggunakan form-select Bootstrap --}}
                <select class="form-select" id="status_aktif" name="status_aktif">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status_aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status_aktif') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{-- Menggunakan btn Bootstrap --}}
                <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
                <a href="{{ route('bpdpks.kerjasama.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    {{-- ===================== DAFTAR KAMPUS (Custom Card, Fungsionalitas Bootstrap) ===================== --}}
    <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl border border-gray-100">
        <h5 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-list-alt me-3 text-green-600"></i> Daftar Kampus Mitra BPDPKS
        </h5>

        <div class="table-responsive">
            {{-- Menggunakan kelas table Bootstrap --}}
            <table class="table table-hover" id="kampusTable">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Kampus</th>
                        <th>Kode</th>
                        <th>Status</th>
                        <th>Tanggal MoU</th>
                        <th class="text-nowrap" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKampus as $kampus)
                        <tr>
                            <td>{{ $loop->iteration + ($dataKampus->perPage() * ($dataKampus->currentPage() - 1)) }}</td>
                            <td>{{ $kampus->nama_kampus }}</td>
                            <td>{{ $kampus->kode_kampus ?? '-' }}</td>
                            <td>
                                {{-- MENGGUNAKAN FUNGSI BADGE ANDA YANG SUDAH ADA --}}
                                {!! $kampus->getStatusBadge() !!}
                            </td>
                            <td>{{ $kampus->tanggal_mou ? \Carbon\Carbon::parse($kampus->tanggal_mou)->format('d M Y') : 'N/A' }}
                            </td>
                            <td class="d-flex text-nowrap">
                                {{-- Menggunakan kelas btn Bootstrap --}}
                                <a href="{{ route('bpdpks.kerjasama.edit', $kampus->id) }}" class="btn btn-sm btn-warning me-1"
                                    title="Edit Data">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('bpdpks.kerjasama.destroy', $kampus->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kampus ini? Penghapusan akan gagal jika masih ada mahasiswa terdaftar.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data kampus yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{-- Pagination tetap menggunakan bawaan Laravel/Bootstrap --}}
            {{ $dataKampus->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    {{-- Tempat untuk script tambahan --}}
@endsection