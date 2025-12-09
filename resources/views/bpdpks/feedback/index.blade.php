@extends('bpdpks.layouts.bpdpks_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-inbox me-3 text-primary"></i> Monitoring Feedback Mahasiswa</h2>
    </div>
    <p class="text-muted">Daftar lengkap masukan, kritik, dan saran dari penerima beasiswa per semester.</p>
    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark"><i class="fas fa-list-ul me-2 text-primary"></i> Daftar Feedback</h5>
            <span class="badge bg-primary fs-6">Total: {{ $feedbacks->total() }}</span>
        </div>
        <div class="card-body p-0">
            @if ($feedbacks->isEmpty())
                <div class="alert alert-info text-center m-4">
                    <i class="fas fa-info-circle me-2"></i> Belum ada feedback yang masuk saat ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 25%;">Mahasiswa</th>
                                <th style="width: 15%;">Semester</th>
                                <th style="width: 35%;">Cuplikan Feedback</th>
                                <th style="width: 15%;">Tanggal Input</th>
                                <th class="text-center" style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $feedback)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($feedbacks->currentPage() - 1) * $feedbacks->perPage() }}</td>
                                    <td>
                                        <strong class="text-dark">{{ $feedback->mahasiswa->nama_lengkap ?? 'N/A' }}</strong>
                                        <div class="text-secondary small">{{ $feedback->mahasiswa->email ?? 'N/A' }}</div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $feedback->semester_ke }}</span></td>
                                    <td>{{ Str::limit($feedback->isi_feedback, 70, '...') }}</td>
                                    <td><i class="far fa-clock me-1"></i> {{ $feedback->tanggal_input->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('bpdpks.feedback.show', $feedback->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection