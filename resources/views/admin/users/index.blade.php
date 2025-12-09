@extends('admin.layout.LayoutAdmin') 

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid fw-bold text-dark">
    <h1><i class="fas fa-users-cog me-2 fw-bold text-dark"></i>Manajemen User</h1>
    
    {{-- Notifikasi Khusus Password Baru (Hasil Auto Generate) --}}
    @if (session('credentials'))
    <div class="alert alert-success alert-dismissible fade show my-4 shadow-sm" role="alert">
        <h4 class="alert-heading"><i class="fas fa-check-circle"></i> Akun Mahasiswa Berhasil Dibuat!</h4>
        <p>Mohon catat atau berikan detail login berikut kepada mahasiswa:</p>
        <hr>
        <ul class="list-unstyled fw-bold">
            <li><strong>Nama:</strong> {{ session('credentials')['name'] }}</li>
            <li><strong>Email/Login:</strong> <span class="text-primary">{{ session('credentials')['email'] }}</span></li>
            <li><strong>Password:</strong> <span class="badge bg-dark" style="font-size: 1.1em;">{{ session('credentials')['password'] }}</span></li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tombol Aksi Tambah User --}}
    <div class="mb-4">
        {{-- Tombol untuk fitur spesial: Tambah Mahasiswa Otomatis --}}
        <a href="{{ route('admin.users.create_mahasiswa') }}" class="btn btn-primary me-2">
            <i class="fas fa-user-graduate me-1"></i> Tambah Mahasiswa (Auto)
        </a>
        
        {{-- Tombol standard: Tambah Admin/BPDPKS manual --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-secondary">
            <i class="fas fa-user-plus me-1"></i> Tambah Admin/BPDPKS
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Tabel User --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            {{-- Penomoran urut yang benar --}}
                            <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'bpdpks' ? 'warning text-dark' : 'success') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection