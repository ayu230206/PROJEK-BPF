@extends('admin.layout.LayoutAdmin')

@section('title', 'Data Kampus Mitra')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-university me-2"></i> Daftar Kampus Mitra</h1>
            <p class="subtle">Kelola data universitas mitra dan status MoU kerjasama.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.kampus.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                <i class="fas fa-plus me-1"></i> Tambah Kampus
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h5 class="section-title mb-0 border-0 p-0"><i class="fas fa-search me-2"></i> Filter & Pencarian</h5>
        </div>
        
        <form action="{{ route('admin.kampus.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama kampus atau kode..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit" style="background-color: var(--palm-green); border-color: var(--palm-green);">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.kampus.index') }}" class="btn btn-light border" title="Reset"><i class="fas fa-sync"></i></a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>Nama Kampus</th>
                        <th>Kode</th>
                        <th>Status Kerjasama</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKampus as $kampus)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $dataKampus->firstItem() - 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $kampus->nama_kampus }}</div>
                            <small class="text-muted"><i class="fas fa-file-contract me-1"></i> MoU: {{ $kampus->nomor_mou ?? 'Belum ada' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $kampus->kode_kampus ?? '-' }}</span></td>
                        <td>
                            @if($kampus->status_kerjasama == 'aktif')
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Aktif</span>
                            @elseif($kampus->status_kerjasama == 'nonaktif')
                                <span class="badge bg-secondary"><i class="fas fa-minus-circle me-1"></i> Non-Aktif</span>
                            @elseif($kampus->status_kerjasama == 'pending')
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                            @elseif($kampus->status_kerjasama == 'ditolak')
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.kampus.edit', $kampus->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kampus.destroy', $kampus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kampus ini? Data mahasiswa terkait mungkin akan error.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-university fa-3x mb-3 text-secondary"></i><br>
                            Belum ada data kampus yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dataKampus->withQueryString()->links() }}
        </div>
    </div>
@endsection