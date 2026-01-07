@extends('admin.layout.LayoutAdmin')

@section('title', 'Moderasi Forum Mahasiswa')

@section('content')
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-comments me-2"></i> Moderasi Forum</h1>
            <p class="subtle">Pantau dan kelola diskusi mahasiswa. Hapus postingan yang melanggar aturan.</p>
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
        {{-- Header & Pencarian --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="section-title mb-0"><i class="fas fa-list-ul me-2"></i> Daftar Postingan Terbaru</h5>
            
            <form action="{{ route('admin.forum.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari isi / penulis..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="20%">Penulis</th>
                        <th>Isi Postingan</th>
                        <th width="15%">Tanggal Post</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $post->user->nama_lengkap ?? 'User Tidak Dikenal' }}</div>
                            <small class="text-muted">{{ $post->user->email ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="text-dark" style="max-width: 400px;">
                                {{ Str::limit($post->isi, 100) }}
                            </div>
                            {{-- Jika ada gambar, tampilkan badge --}}
                            @if($post->gambar)
                                <span class="badge bg-info mt-1"><i class="fas fa-image me-1"></i> Ada Gambar</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">
                                <i class="far fa-clock me-1"></i> {{ $post->created_at->format('d M Y H:i') }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.forum.destroy', $post->post_id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERINGATAN: Anda yakin ingin menghapus postingan ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white shadow-sm" title="Hapus Postingan">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-comment-slash fa-3x mb-3 text-secondary"></i><br>
                            Belum ada postingan di forum.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection