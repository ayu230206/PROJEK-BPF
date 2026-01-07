@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Detail Feedback Mahasiswa')

@section('content')

    {{-- ===================== HEADER MODERN ===================== --}}
    <div
        class="flex justify-between items-center bg-green-700 p-6 md:p-8 rounded-[18px] text-white shadow-xl shadow-green-700/50 mb-8">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i class="fas fa-search me-2"></i> Detail Feedback Mahasiswa
            </h1>
            <p class="text-sm opacity-85 mt-1">Informasi lengkap masukan dari
                **{{ $feedback->mahasiswa->nama_lengkap ?? 'Mahasiswa' }}** (Semester {{ $feedback->semester_ke }}).</p>
        </div>
        {{-- Tombol Kembali diseragamkan --}}
        <a href="{{ route('bpdpks.feedback.index') }}" class="px-5 py-3 text-sm font-semibold rounded-xl transition duration-200 ease-in-out 
              bg-gray-500 border border-gray-500 hover:bg-gray-600 text-white shadow-lg hover:scale-[1.02]">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">

        {{-- ===================== KOLOM KIRI (FULL WIDTH): DETAIL ISI FEEDBACK ===================== --}}
        <div class="col-md-12">

            {{-- KARTU DETAIL ISI FEEDBACK --}}
            <div class="bg-white p-6 shadow-xl rounded-2xl border-l-4 border-green-700 mb-6">
                <div class="border-b pb-3 mb-4">
                    <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-comment-dots me-2 text-green-700"></i>
                        Isi Feedback dari Mahasiswa</h5>
                </div>
                <blockquote class="blockquote mb-0 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="card-text fs-5 text-gray-800" style="white-space: pre-wrap;">{{ $feedback->isi_feedback }}</p>
                    <footer class="blockquote-footer mt-3 pt-2 border-t border-gray-300">
                        Dikirim pada: {{ $feedback->tanggal_input->format('d F Y') }}
                    </footer>
                </blockquote>
            </div>

            {{-- KARTU INFO MAHASISWA (Dipindahkan ke bawah dan disederhanakan) --}}
            <div class="bg-white p-0 shadow-xl rounded-2xl mb-6">
                {{-- Card Header --}}
                <div class="p-4 border-b border-gray-100">
                    <h5 class="mb-0 text-lg font-semibold text-gray-800"><i class="fas fa-user-tag me-2 text-green-700"></i>
                        Data Pengirim</h5>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                        <strong>Nama:</strong> <span
                            class="text-end">{{ $feedback->mahasiswa->nama_lengkap ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                        <strong>Email:</strong> <span class="text-end">{{ $feedback->mahasiswa->email ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                        <strong>Semester Ke-:</strong> <span
                            class="badge bg-secondary text-white fs-6 px-3 py-1">{{ $feedback->semester_ke }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                        <strong>Tanggal Kirim:</strong> <span
                            class="text-end">{{ $feedback->tanggal_input->format('d/m/Y') }}</span>
                    </li>
                    {{-- STATUS EVALUASI DIHAPUS SESUAI PERMINTAAN --}}
                </ul>
            </div>

        </div>

    

    </div>
@endsection