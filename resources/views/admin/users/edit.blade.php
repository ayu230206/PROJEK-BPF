@extends('admin.layout.LayoutAdmin')

@section('title', 'Edit User: ' . $user->nama_lengkap)

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit User: {{ $user->nama_lengkap }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Logic khusus jika user adalah mahasiswa --}}
                @if($user->role == 'mahasiswa')
                <div class="mb-3">
                    <label class="form-label">Asal Kampus</label>
                    <select name="asal_kampus" class="form-select @error('asal_kampus') is-invalid @enderror">
                        @foreach($kampus as $k)
                            <option value="{{ $k->id }}" {{ $user->asal_kampus == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="role" value="mahasiswa">
                    @error('asal_kampus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="bpdpks" {{ $user->role == 'bpdpks' ? 'selected' : '' }}>BPDPKS</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endif
                
                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi hanya jika ingin ganti password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt me-1"></i> Update Data</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection