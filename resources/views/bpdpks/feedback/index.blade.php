@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Monitoring Feedback Mahasiswa')

@section('content')

{{-- ===================== HEADER MODERN (Menggunakan Kelas Tailwind) ===================== --}}
<div class="flex items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
    <div>
        <h1 class="text-2xl font-bold flex items-center gap-3">
            <i class="fas fa-inbox me-2"></i> Monitoring Feedback Mahasiswa
        </h1>
        <p class="text-sm opacity-85 mt-1">Daftar lengkap masukan, kritik, dan saran dari penerima beasiswa per semester.</p>
    </div>
</div>
    
{{-- ===================== CARD DATA FEEDBACK (Menggunakan Kelas Tailwind) ===================== --}}
<div class="bg-white p-0 shadow-xl rounded-2xl border border-gray-100">
    
    {{-- Card Header --}}
    <div class="p-4 border-b border-gray-100 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-lg font-semibold text-gray-800"><i class="fas fa-list-ul me-2 text-green-700"></i> Daftar Feedback</h5>
        {{-- Badge diubah ke warna hijau konsisten --}}
        <span class="badge text-white bg-green-600 fs-6 px-3 py-2">Total: {{ $feedbacks->total() }}</span>
    </div>
    
    <div class="card-body p-0">
        @if ($feedbacks->isEmpty())
            <div class="alert alert-info text-center m-4 rounded-xl">
                <i class="fas fa-info-circle me-2"></i> Belum ada feedback yang masuk saat ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
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
                                {{-- Badge Semester dipertahankan namun diberi sedikit margin/padding --}}
                                <td><span class="badge bg-secondary px-3 py-1">{{ $feedback->semester_ke }}</span></td>
                                <td>{{ Str::limit($feedback->isi_feedback, 70, '...') }}</td>
                                <td><i class="far fa-clock me-1 text-muted"></i> {{ $feedback->tanggal_input->format('d M Y') }}</td>
                                <td class="text-center">
                                    {{-- PERUBAHAN: Tombol Aksi diubah dari ikon mata menjadi tulisan "Detail" --}}
                                    <a href="{{ route('bpdpks.feedback.show', $feedback->id) }}" class="btn btn-sm text-white bg-green-600 hover:bg-green-700 px-3 py-1" title="Lihat Detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Card Footer Pagination --}}
            <div class="p-4 border-t border-gray-100">
                {{ $feedbacks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection