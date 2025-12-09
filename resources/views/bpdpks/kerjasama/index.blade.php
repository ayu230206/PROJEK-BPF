@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Kampus & Kerjasama')

@section('content')

    <div class="header d-flex justify-content-between align-items-center mb-4">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-university me-2"></i> Data Kampus & Kerjasama</h1>
            <p class="subtle">Manajemen daftar universitas dan status kerjasama dengan BPDPKS.</p>
        </div>
        <div class="controls">
            <a href="{{ route('bpdpks.kerjasama.create') }}" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary);">
                <i class="fas fa-plus me-1"></i> Tambah Kampus
            </a>
        </div>
    </div>

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

    <div class="card-custom mb-4 shadow-sm">
        <h5 class="section-title mb-3">Filter Data Kampus</h5>
        <form action="{{ route('bpdpks.kerjasama.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label">Cari Nama/Kode Kampus</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama atau Kode Kampus">
            </div>
            <div class="col-md-3">
                <label for="status_aktif" class="form-label">Status Kerjasama</label>
                <select class="form-select" id="status_aktif" name="status_aktif">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status_aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status_aktif') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
                <a href="{{ route('bpdpks.kerjasama.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>


    <div class="card-custom shadow-sm">
        <h5 class="section-title mb-3">Daftar Kampus Mitra BPDPKS</h5>
        <div class="table-responsive">
            <table class="table table-hover" id="kampusTable">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Kampus</th>
                        <th>Kode</th>
                        <th>Status</th>
                        <th>Tanggal MoU</th>
                        {{-- Memastikan lebar kolom Aksi cukup --}}
                        <th class="text-nowrap" style="width: 150px;">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKampus as $kampus)
                    <tr>
                        <td>{{ $loop->iteration + ($dataKampus->perPage() * ($dataKampus->currentPage() - 1)) }}</td>
                        <td>{{ $kampus->nama_kampus }}</td>
                        <td>{{ $kampus->kode_kampus ?? '-' }}</td>
                        <td>{!! $kampus->getStatusBadge() !!}</td>
                        <td>{{ $kampus->tanggal_mou ? \Carbon\Carbon::parse($kampus->tanggal_mou)->format('d M Y') : 'N/A' }}</td>
                        
                        <td class="d-flex text-nowrap"> 
                            {{-- Tombol Edit (Kuning) - DITAMBAH TEKS "Edit" dan kelas me-1 pada ikon --}}
                            <a href="{{ route('bpdpks.kerjasama.edit', $kampus->id) }}" class="btn btn-sm btn-warning me-1" title="Edit Data">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            
                            {{-- Form Hapus (Merah) - DITAMBAH TEKS "Hapus" dan kelas me-1 pada ikon --}}
                            <form action="{{ route('bpdpks.kerjasama.destroy', $kampus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kampus ini? Penghapusan akan gagal jika masih ada mahasiswa terdaftar.')">
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
            {{ $dataKampus->links() }}
        </div>
    </div>

@endsection

@section('scripts')
{{-- Tempat untuk script tambahan --}}
@endsection