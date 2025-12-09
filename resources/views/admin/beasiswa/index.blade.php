@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Program Beasiswa')

@section('content')
    {{-- Header Halaman --}}
    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-graduation-cap me-2"></i> Program Beasiswa</h1>
            <p class="subtle">Kelola informasi, jadwal, dan penerimaan beasiswa sawit.</p>
        </div>
        <div class="controls mb-4">
            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                <i class="fas fa-plus me-1"></i> Buat Program Baru
            </a>
        </div>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Tabel Data --}}
    <div class="card-custom">
        <h5 class="section-title"><i class="fas fa-list-ul me-2"></i> Daftar Program Tersedia</h5>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 30%;">Judul Program</th>
                        <th>Jadwal Pendaftaran</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $index => $program)
                        <tr>
                            <td class="text-center">{{ $index + 1 + ($programs->currentPage() - 1) * $programs->perPage() }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $program->judul }}</span>
                            </td>
                            <td>
                                @if($program->tanggal_mulai && $program->tanggal_berakhir)
                                    <div class="d-flex flex-col text-sm">
                                        <span class="text-success"><i class="fas fa-play-circle me-1"></i> {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }}</span>
                                        <span class="text-danger"><i class="fas fa-stop-circle me-1"></i> {{ \Carbon\Carbon::parse($program->tanggal_berakhir)->format('d M Y') }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $now = now();
                                    $start = $program->tanggal_mulai ? \Carbon\Carbon::parse($program->tanggal_mulai) : null;
                                    $end = $program->tanggal_berakhir ? \Carbon\Carbon::parse($program->tanggal_berakhir) : null;
                                @endphp

                                @if($start && $end)
                                    @if($now->between($start, $end))
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i> Buka</span>
                                    @elseif($now->lt($start))
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Segera</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-lock me-1"></i> Tutup</span>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark border">Draft</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-user-circle me-1"></i> {{ $program->createdBy->nama_lengkap ?? 'Admin' }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.beasiswa.edit', $program->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.beasiswa.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
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
                                <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i><br>
                                Belum ada Program Beasiswa yang diinput.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $programs->links() }}
        </div>
    </div>
@endsection