@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Pengumuman/Notifikasi')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-white d-flex justify-content-between align-items-center d-flex mb-4 fw-bold text-dark">
        <h4 class="mb-0">Daftar Pengumuman ke Mahasiswa</h4>
        <a href="{{ route('admin.notifikasi.create') }}" class="btn btn-primary">
            <i class="fas fa-paper-plane me-1"></i> Buat Pengumuman Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Judul Pengumuman</th>
                        <th>Target Role</th>
                        <th>Dikirim Pada</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifikasis as $index => $notifikasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notifikasi->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $notifikasi->role_penerima ?? 'Mahasiswa' }}</span></td>
                            <td>{{ $notifikasi->created_at->format('d M Y H:i') }}</td>
                            <td>
                                {{-- Aksi Hapus --}}
                                <form action="{{ route('admin.notifikasi.destroy', $notifikasi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pengumuman ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada Pengumuman yang tersimpan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $notifikasis->links() }}
    </div>
</div>
@endsection