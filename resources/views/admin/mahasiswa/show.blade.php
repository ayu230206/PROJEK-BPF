@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <a href="{{ route('admin.mahasiswa.data.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>
    
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Detail Mahasiswa: {{ $mahasiswa->user->nama_lengkap ?? 'N/A' }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <img src="{{ asset('images/default-avatar.png') }}" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                    <h5>{{ $mahasiswa->nim }}</h5>
                    <p class="text-muted">{{ $mahasiswa->kampus->nama_kampus ?? '-' }}</p>
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>: {{ $mahasiswa->user->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $mahasiswa->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td>: {{ $mahasiswa->prodi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td>: {{ $mahasiswa->user->angkatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $mahasiswa->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Domisili</th>
                            <td>: {{ $mahasiswa->alamat_domisili ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">Data diupdate terakhir: {{ $mahasiswa->updated_at->format('d M Y H:i') }}</small>
        </div>
    </div>
</div>
@endsection