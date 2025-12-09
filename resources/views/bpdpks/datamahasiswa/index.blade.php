@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Data Mahasiswa Penerima')

@section('content')

    <div class="header d-flex justify-content-between align-items-center mb-4">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-user-graduate me-2"></i> Data Mahasiswa Penerima</h1>
            <p class="subtle">Daftar lengkap data diri dan performa akademik mahasiswa penerima beasiswa.</p>
        </div>
    </div>
    
    @if (session('success'))
        {{-- Styling alert diperbaiki agar bisa ditutup (dismissible) --}}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        {{-- Styling alert diperbaiki agar bisa ditutup (dismissible) --}}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom mb-4 shadow-sm">
        <h5 class="section-title mb-3">Filter & Pencarian</h5>
        <form action="{{ route('bpdpks.datamahasiswa.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label">Cari Nama/NIM/Kampus</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama, NIM, atau Nama Kampus">
            </div>
            <div class="col-md-3">
                <label for="kampus_id" class="form-label">Filter Kampus</label>
                <select class="form-select" id="kampus_id" name="kampus_id">
                    <option value="">Semua Kampus</option>
                    @foreach ($allKampus as $kampus)
                        <option value="{{ $kampus->id }}" {{ (string)request('kampus_id') === (string)$kampus->id ? 'selected' : '' }}>
                            {{ $kampus->nama_kampus }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                {{-- Menambahkan ikon pada tombol Filter dan Reset untuk styling --}}
                <button type="submit" class="btn btn-info text-white me-2"><i class="fas fa-filter me-1"></i> Terapkan Filter</button>
                <a href="{{ route('bpdpks.datamahasiswa.index') }}" class="btn btn-secondary"><i class="fas fa-redo me-1"></i> Reset</a>
            </div>
        </form>
    </div>


    <div class="card-custom shadow-sm">
        <h5 class="section-title mb-3">Tabel Data Mahasiswa</h5>
        
        <div class="table-responsive">
            {{-- MENGHAPUS ID TABEL ("mahasiswaTable") untuk menghilangkan panah sorting besar. --}}
            <table class="table table-hover align-middle"> 
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>NIM / Nama Lengkap</th>
                        <th>Kampus / Prodi</th>
                        <th style="width: 100px;">Angkatan</th>
                        <th style="width: 80px;">IPK</th>
                        <th style="width: 120px;">Status IPK</th>
                        {{-- Lebar Aksi diperlebar untuk menampung teks "Detail" --}}
                        <th class="text-nowrap" style="width: 120px;">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
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
                        <td class="text-nowrap"> 
                            {{-- Perbaikan Aksi: Menambahkan teks "Detail" di samping ikon (styling) --}}
                            <a href="{{ route('bpdpks.datamahasiswa.show', $mahasiswa->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail Data Mahasiswa">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-exclamation-circle me-2"></i> Tidak ada data mahasiswa yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{-- MENGGUNAKAN VIEW BOOTSTRAP 5 UNTUK PAGINATION --}}
            {{ $dataMahasiswa->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@section('scripts')
@endsection