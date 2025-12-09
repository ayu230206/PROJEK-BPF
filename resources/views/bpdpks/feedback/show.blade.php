@extends('bpdpks.layouts.bpdpks_layout')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-search me-3 text-primary"></i> Detail Feedback Mahasiswa</h2>
        <a href="{{ route('bpdpks.feedback.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar</a>
    </div>

    <p class="text-muted">Informasi lengkap masukan dari **{{ $feedback->mahasiswa->nama_lengkap ?? 'Mahasiswa' }}** (Semester {{ $feedback->semester_ke }}).</p>

    <div class="row">
        
        {{-- KARTU DETAIL FEEDBACK --}}
        <div class="col-md-8">
            <div class="card shadow-lg mb-4 border-start border-5 border-primary">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-primary">Isi Feedback dari Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0 p-3 bg-light rounded">
                        <p class="card-text fs-5" style="white-space: pre-wrap;">{{ $feedback->isi_feedback }}</p>
                        <footer class="blockquote-footer mt-2">
                            Dikirim pada: {{ $feedback->tanggal_input->format('d F Y') }}
                        </footer>
                    </blockquote>
                </div>
            </div>

            {{-- FORM TINDAK LANJUT/EVALUASI (OPSIONAL) --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i> Tindak Lanjut Evaluasi BPDPKS</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info small">
                        Tempat ini dapat digunakan untuk menambahkan form status evaluasi, atau catatan balasan dari tim BPDPKS.
                    </div>
                    {{-- Di sini Anda bisa menambahkan form untuk mengubah status_evaluasi --}}
                    {{-- Contoh: <form>...</form> --}}
                </div>
            </div>
        </div>
        
        {{-- KARTU INFO MAHASISWA & STATUS --}}
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-user-tag me-2"></i> Data Pengirim</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Nama:</strong> <span class="float-end">{{ $feedback->mahasiswa->nama_lengkap ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> <span class="float-end">{{ $feedback->mahasiswa->email ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Semester Ke-:</strong> <span class="badge bg-secondary float-end fs-6">{{ $feedback->semester_ke }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Tanggal Kirim:</strong> <span class="float-end">{{ $feedback->tanggal_input->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Status Evaluasi:</strong> 
                            <span class="float-end">
                                @if (isset($feedback->status_evaluasi) && $feedback->status_evaluasi == 'Selesai')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-hourglass-half me-1"></i> Belum Dievaluasi</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection