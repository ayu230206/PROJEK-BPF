@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Registrasi Ulang')

@section('content')
<div class="container-fluid">
    <h1 class = "text-dark fw-bold"><i class="fas fa-redo-alt me-2 text-dark fw-bold"></i>Permohonan Registrasi Ulang</h1>
    <p class="text-muted">Daftar mahasiswa yang mengajukan Registrasi Ulang (Wajib diisi setiap semester).</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Semester Ke-</th>
                            <th>Sudah Feedback</th>
                            <th>Syarat Nilai (IPK)</th>
                            <th>Status Regis</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Logika loop data dari Controller AdminRegisUlangController@index --}}
                        @forelse($dataRegis as $regis)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $regis->user->nama_lengkap ?? 'N/A' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $regis->semester_ke }}</span></td>
                            <td>
                                @if($regis->sudah_feedback)
                                    <span class="badge bg-success">Sudah</span>
                                @else
                                    <span class="badge bg-danger">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($regis->syarat_nilai_terpenuhi)
                                    <span class="badge bg-success">Memenuhi</span>
                                @else
                                    <span class="badge bg-danger">Tidak</span>
                                @endif
                            </td>
                            <td>
                                @if($regis->status_regis == 'disetujui')
                                    <span class="badge bg-primary">Disetujui</span>
                                @elseif($regis->status_regis == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($regis->status_regis == 'pending')
                                    <form action="{{ route('admin.regis-ulang.approve', $regis->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.regis-ulang.reject', $regis->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Sudah Diproses</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada permohonan Registrasi Ulang yang pending.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Jika menggunakan pagination, tambahkan ini: --}}
        {{-- <div class="card-footer">{{ $dataRegis->links() }}</div> --}}
    </div>
</div>
@endsection