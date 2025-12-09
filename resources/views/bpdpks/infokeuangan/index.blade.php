@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Informasi Keuangan')

@section('content')

    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-wallet me-2"></i> Informasi Keuangan Beasiswa</h1>
            <p class="subtle">Manajemen status pencairan dana beasiswa untuk setiap mahasiswa.</p>
        </div>
        <div class="controls">
            <a href="{{ route('bpdpks.keuangan.create') }}" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);">
                <i class="fas fa-plus me-1"></i> Tambah Data Pencairan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card-custom mb-4">
        <h5 class="section-title">Filter Data</h5>
        <form action="{{ route('bpdpks.keuangan.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Mahasiswa/NIM</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama, NIM, atau Kampus">
            </div>
            <div class="col-md-3">
                <label for="semester_filter" class="form-label">Semester</label>
                <input type="text" class="form-control" id="semester_filter" name="semester_filter" value="{{ request('semester_filter') }}" placeholder="Contoh: 5">
            </div>
            <div class="col-md-3">
                <label for="status_filter" class="form-label">Status Pencairan</label>
                <select class="form-select" id="status_filter" name="status_filter">
                    <option value="">Semua Status</option>
                    <option value="proses" {{ request('status_filter') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="ditransfer" {{ request('status_filter') == 'ditransfer' ? 'selected' : '' }}>Ditransfer</option>
                    <option value="diterima" {{ request('status_filter') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditangguhkan" {{ request('status_filter') == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
                <a href="{{ route('bpdpks.keuangan.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>


    <div class="card-custom">
        <h5 class="section-title">Daftar Status Pencairan Dana</h5>
        <div class="table-responsive">
            <table class="table table-hover datatable" id="keuanganTable">
                <thead>
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
                    <tr>
                        <td>{{ $loop->iteration + ($dataKeuangan->perPage() * ($dataKeuangan->currentPage() - 1)) }}</td>
                        {{-- Menggunakan null coalescing operator untuk menghindari error jika relasi belum dimuat --}}
                        <td>{{ $keuangan->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $keuangan->mahasiswa->detail->nim ?? 'N/A' }}</td>
                        <td>{{ $keuangan->mahasiswa->detail->kampus->nama_kampus ?? 'N/A' }}</td>
                        <td>{{ $keuangan->semester }}</td>
                        <td>{{ $keuangan->tanggal_transfer ? \Carbon\Carbon::parse($keuangan->tanggal_transfer)->format('d M Y') : '-' }}</td>
                        {{-- Perbaikan: Menggunakan number_format untuk format Rupiah --}}
                        <td>Rp {{ number_format($keuangan->jumlah_bulanan, 0, ',', '.') }}</td>
                        <td>{!! $keuangan->getStatusBadge() !!}</td>
                        <td class="d-flex">
                            {{-- Tombol Edit (Kuning) --}}
                            <a href="{{ route('bpdpks.keuangan.edit', $keuangan->id) }}" class="btn btn-sm btn-warning me-1" title="Edit Data">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            
                            {{-- Form Hapus (Merah) --}}
                            <form action="{{ route('bpdpks.keuangan.destroy', $keuangan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keuangan ini?')">
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
                        <td colspan="9" class="text-center">Tidak ada data keuangan yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $dataKeuangan->links() }}
        </div>
    </div>

@endsection

@section('scripts')
{{-- Tidak ada perubahan di script --}}
@endsection