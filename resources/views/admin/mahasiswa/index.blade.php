@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 fw-bold text-dark">
        <h2>Data Mahasiswa (Penerima Beasiswa)</h2>
    </div>

    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('admin.mahasiswa.data.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama / NIM..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="kampus_id" class="form-select">
                        <option value="">-- Semua Kampus --</option>
                        @foreach($allKampus as $k)
                            <option value="{{ $k->id }}" {{ request('kampus_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kampus }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive bg-white shadow-sm p-3 rounded">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Kampus</th>
                    <th>Prodi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataMahasiswa as $mhs)
                <tr>
                    <td>{{ $loop->iteration + $dataMahasiswa->firstItem() - 1 }}</td>
                    <td>
                        <div class="fw-bold">{{ $mhs->user->nama_lengkap ?? 'User Dihapus' }}</div>
                        <small class="text-muted">{{ $mhs->user->email ?? '-' }}</small>
                    </td>
                    <td>{{ $mhs->nim ?? '-' }}</td>
                    <td>{{ $mhs->kampus->nama_kampus ?? '-' }}</td>
                    <td>{{ $mhs->prodi ?? '-' }}</td>
                    <td>
                        {{-- Menggunakan route show --}}
                        <a href="{{ route('admin.mahasiswa.data.show', $mhs->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Tidak ada data mahasiswa ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $dataMahasiswa->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection