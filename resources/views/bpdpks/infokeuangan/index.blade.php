@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Informasi Keuangan')

@section('content')

    {{-- HEADER: Menggunakan Tailwind CSS untuk Tampilan Modern (Warna Hijau Dashboard) --}}
    <div
        class="flex justify-between items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-6">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-wallet me-2"></i> Informasi Keuangan Beasiswa
            </h1>
            <p class="text-sm opacity-85 mt-1">Manajemen status pencairan dana beasiswa untuk setiap mahasiswa.</p>
        </div>
        {{-- Tombol Tambah: Menggunakan warna hijau yang lebih gelap --}}
        <a href="{{ route('bpdpks.keuangan.create') }}"
            class="px-5 py-3 text-sm font-semibold rounded-xl transition duration-200 ease-in-out 
                  bg-green-800 border border-green-800 hover:bg-green-900 text-white shadow-lg shadow-green-700/50 hover:scale-[1.02]">
            <i class="fas fa-plus me-1"></i> Tambah Data Pencairan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- CARD FILTER: Menggunakan Tailwind CSS (Mereplikasi .card-custom) --}}
    <div class="bg-white p-6 md:p-8 rounded-16px shadow-lg border border-gray-100 mb-6">
        {{-- Section Title (Icon berwarna Hijau) --}}
        <h5 class="text-lg font-semibold text-gray-700 border-b pb-3 mb-6 flex items-center">
            <i class="fas fa-filter me-2 text-green-600"></i> Filter Data
        </h5>
        {{-- Form: Menggunakan Bootstrap Grid dan Form Controls --}}
        <form action="{{ route('bpdpks.keuangan.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Mahasiswa/NIM</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Nama, NIM, atau Kampus">
            </div>
            <div class="col-md-3">
                <label for="semester_filter" class="form-label">Semester</label>
                <input type="text" class="form-control" id="semester_filter" name="semester_filter"
                    value="{{ request('semester_filter') }}" placeholder="Contoh: 5">
            </div>
            <div class="col-md-3">
                <label for="status_filter" class="form-label">Status Pencairan</label>
                <select class="form-select" id="status_filter" name="status_filter">
                    <option value="">Semua Status</option>
                    <option value="proses" {{ request('status_filter') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="ditransfer" {{ request('status_filter') == 'ditransfer' ? 'selected' : '' }}>Ditransfer
                    </option>
                    <option value="diterima" {{ request('status_filter') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditangguhkan" {{ request('status_filter') == 'ditangguhkan' ? 'selected' : '' }}>
                        Ditangguhkan</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-info text-white me-2 w-100">Terapkan Filter</button>
                <a href="{{ route('bpdpks.keuangan.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    {{-- CARD DATA TABLE: Menggunakan Tailwind CSS (Mereplikasi .card-custom) --}}
    <div class="bg-white p-6 md:p-8 rounded-16px shadow-lg border border-gray-100">
        <h5 class="text-lg font-semibold text-gray-700 border-b pb-3 mb-6 flex items-center">
            <i class="fas fa-list me-2 text-green-600"></i> Daftar Status Pencairan Dana
        </h5>
        <div class="table-responsive">
            {{-- Table: Menggunakan class Bootstrap --}}
            <table class="table table-hover datatable" id="keuanganTable">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kampus</th>
                        <th>Semester</th>
                        <th>Tgl Transfer</th>
                        <th>Jml Bulanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKeuangan as $keuangan)
                        <tr class="hover:bg-green-50/50 transition duration-100">
                            <td>{{ $loop->iteration + ($dataKeuangan->perPage() * ($dataKeuangan->currentPage() - 1)) }}</td>
                            <td>{{ $keuangan->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $keuangan->mahasiswa->detail->nim ?? 'N/A' }}</td>
                            <td>{{ $keuangan->mahasiswa->detail->kampus->nama_kampus ?? 'N/A' }}</td>
                            <td>{{ $keuangan->semester }}</td>
                            <td>{{ $keuangan->tanggal_transfer ? \Carbon\Carbon::parse($keuangan->tanggal_transfer)->format('d M Y') : '-' }}
                            </td>
                            <td class="text-green-700 fw-bold">Rp {{ number_format($keuangan->jumlah_bulanan, 0, ',', '.') }}
                            </td>

                            {{-- PERBAIKAN: Menambahkan class text-dark untuk memastikan badge terlihat --}}
                            <td class="text-dark">{!! $keuangan->getStatusBadge() !!}</td>

                            <td class="d-flex">
                                <a href="{{ route('bpdpks.keuangan.edit', $keuangan->id) }}" class="btn btn-sm btn-warning me-1"
                                    title="Edit Data">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('bpdpks.keuangan.destroy', $keuangan->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keuangan ini?')">
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
                            <td colspan="9" class="text-center">
                                <div class="py-10 text-gray-500">
                                    <i class="fas fa-info-circle text-2xl mb-3"></i>
                                    <p class="text-lg font-medium">Tidak ada data keuangan yang tersedia.</p>
                                    <a href="{{ route('bpdpks.keuangan.create') }}"
                                        class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-150">
                                        Tambah Data Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Paginasi: Menggunakan Bootstrap/Laravel links() --}}
        <div class="mt-3 flex justify-center">
            {{ $dataKeuangan->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    {{-- Script tambahan jika diperlukan --}}
@endsection