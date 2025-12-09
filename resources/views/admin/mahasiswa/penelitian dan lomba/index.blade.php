@extends('admin.layout.LayoutAdmin')

@section('title', 'Daftar Penelitian dan Lomba')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-trophy me-2"></i> Penelitian & Lomba</h1>
            <p class="subtle">Kelola informasi kompetisi akademik dan riset sawit.</p>
        </div>
        <div class="controls mb-4">
            <a href="{{ route('admin.penelitian-lomba.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                <i class="fas fa-plus me-1"></i> Tambah Kegiatan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom">
        <h5 class="section-title"><i class="fas fa-list me-2"></i> Daftar Kegiatan</h5>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>Kategori</th>
                        <th width="25%">Judul Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Deskripsi Singkat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataPenelitianLomba as $program)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            @if($program->tipe == 'lomba')
                                <span class="badge bg-warning text-dark"><i class="fas fa-medal me-1"></i> Lomba</span>
                            @else
                                <span class="badge bg-info text-dark"><i class="fas fa-microscope me-1"></i> Penelitian</span>
                            @endif
                        </td>
                        <td><span class="fw-bold text-dark">{{ $program->judul }}</span></td>
                        <td>{{ $program->penyelenggara ?? '-' }}</td>
                        <td>{{ Str::limit($program->deskripsi, 60) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.penelitian-lomba.edit', $program->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.penelitian-lomba.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-3x mb-3 text-secondary"></i><br>
                            Tidak ada data Program Penelitian dan Lomba.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination jika ada --}}
        <div class="mt-4">
            {{ $dataPenelitianLomba->links() }}
        </div>
    </div>
@endsection