@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Data Mahasiswa Penerima')

@section('content')

    {{-- ===================== HEADER MODERN (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-user-graduate me-2"></i> Data Mahasiswa Penerima
            </h1>
            <p class="text-sm opacity-85 mt-1">Daftar lengkap data diri dan performa akademik mahasiswa penerima beasiswa.
            </p>
        </div>
    </div>

    {{-- ===================== ALERT MESSAGES (Kelas Bootstrap dengan Styling Konsisten) ===================== --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-xl mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-xl mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===================== CARD FILTER (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100 mb-6">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-filter me-2 text-green-700"></i>
            Filter & Pencarian</h5>
        <form action="{{ route('bpdpks.datamahasiswa.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label font-medium text-gray-700">Cari Nama/NIM/Kampus</label>
                {{-- Fungsi tidak diubah --}}
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Nama, NIM, atau Nama Kampus">
            </div>
            <div class="col-md-3">
                <label for="kampus_id" class="form-label font-medium text-gray-700">Filter Kampus</label>
                {{-- Fungsi tidak diubah --}}
                <select class="form-select" id="kampus_id" name="kampus_id">
                    <option value="">Semua Kampus</option>
                    @foreach ($allKampus as $kampus)
                        <option value="{{ $kampus->id }}" {{ (string) request('kampus_id') === (string) $kampus->id ? 'selected' : '' }}>
                            {{ $kampus->nama_kampus }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{-- Tombol Filter diubah ke warna hijau konsisten --}}
                <button type="submit" class="btn btn-primary bg-green-600 hover:bg-green-700 text-white me-2">
                    <i class="fas fa-filter me-1"></i> Terapkan Filter
                </button>
                {{-- Tombol Reset diubah ke warna abu-abu konsisten --}}
                <a href="{{ route('bpdpks.datamahasiswa.index') }}"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>


    {{-- ===================== CARD DATA MAHASISWA (Menggunakan Kelas Tailwind) ===================== --}}
    <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">
        <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-table me-2 text-green-700"></i>
            Tabel Data Mahasiswa</h5>

        <div class="table-responsive">
            {{-- FUNGSI TIDAK DIUBAH: ID tabel dihapus --}}
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>NIM / Nama Lengkap</th>
                        <th>Kampus / Prodi</th>
                        <th style="width: 100px;">Angkatan</th>
                        <th style="width: 80px;">IPK</th>
                        <th style="width: 120px;">Status IPK</th>
                        {{-- <th class="text-nowrap" style="width: 120px;">Aksi</th> <-- DIHAPUS --}} </tr>
                </thead>
                <tbody>
                    {{-- FUNGSI TIDAK DIUBAH --}}
                    @forelse ($dataMahasiswa as $mahasiswa)
                        <tr>
                            <td>{{ $loop->iteration + ($dataMahasiswa->perPage() * ($dataMahasiswa->currentPage() - 1)) }}</td>
                            <td>
                                <strong>{{ $mahasiswa->user->nama_lengkap }}</strong><br>
                                <small class="text-muted">{{ $mahasiswa->nim }}</small>
                            </td>
                            <td>
                                {{ $mahasiswa->kampus->nama_kampus ?? 'N/A' }}<br>
                                <small class="text-info">{{ $mahasiswa->program_studi }}</small>
                            </td>
                            <td>{{ $mahasiswa->user->angkatan ?? 'N/A' }}</td>
                            <td><strong>{{ $mahasiswa->ipk }}</strong></td>
                            <td>{!! $mahasiswa->ipk_badge !!}</td>
                            {{-- <td class="text-nowrap"> <-- DIHAPUS <a
                                    href="{{ route('bpdpks.datamahasiswa.show', $mahasiswa->id) }}"
                                    class="btn btn-sm text-white bg-blue-500 hover:bg-blue-600"
                                    title="Lihat Detail Data Mahasiswa">
                                    <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            {{-- COLSPAN diubah dari 7 menjadi 6 --}}
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-exclamation-circle me-2"></i> Tidak ada data mahasiswa yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{-- FUNGSI PAGINATION TIDAK DIUBAH --}}
            {{ $dataMahasiswa->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@section('scripts')
@endsection