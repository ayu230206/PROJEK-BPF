@extends('mahasiswa.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-teal-100 p-4 md:p-6">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- JUDUL HALAMAN --}}
        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-comment-dots mr-3 text-green-600"></i> Feedback Beasiswa
            </h2>
        </div>
        <p class="text-gray-600">Isi masukan Anda untuk semester ini dan lihat riwayat feedback yang sudah pernah dikirim.</p>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 flex items-center shadow-sm border border-green-200" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 flex items-center shadow-sm border border-red-200" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 shadow-md bg-red-100 border-l-4 border-red-500 text-red-700 mb-6 rounded-lg">
                <h5 class="font-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Gagal Mengirim Feedback!</h5>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM FEEDBACK --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border-l-4 border-green-500">
            <div class="p-4 bg-gradient-to-r from-green-600 to-teal-600 text-white">
                <h5 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-edit mr-2"></i> Formulir Feedback Semester {{ $semesterSaatIni }}
                </h5>
            </div>
            <div class="p-6 pb-12">
                
                {{-- PESAN PENTING --}}
                @if ($riwayatFeedback->isEmpty())
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 flex items-center shadow-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Penting: Anda belum pernah mengisi feedback. Mohon segera isi formulir ini untuk memenuhi kewajiban semester pertama Anda.
                    </div>
                @elseif ($sudahMengisi)
                    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 border border-blue-200 flex items-center shadow-sm">
                        <i class="fas fa-info-circle mr-2"></i> Anda telah mengisi feedback untuk semester ini. Anda dapat mengedit atau mengirim ulang feedback, kiriman terbaru akan menggantikan yang lama.
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('mahasiswa.feedback.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="semester_ke" value="{{ $semesterSaatIni }}">

                    <div>
                        <label for="isi_feedback" class="block text-gray-700 font-bold mb-2">Kritik, Saran, dan Masukan Anda</label>
                        <p class="text-gray-500 text-sm mb-2">Sampaikan masukan Anda mengenai beasiswa atau layanan (minimal 10 karakter).</p>
                        <textarea 
                            class="w-full p-3 border rounded-lg focus:ring-green-500 focus:border-green-500 @error('isi_feedback') border-red-500 @enderror shadow-sm" 
                            id="isi_feedback" 
                            name="isi_feedback" 
                            rows="6" 
                            placeholder="Tuliskan masukan Anda di sini..."
                            required>{{ old('isi_feedback', $feedbackSaatIni->isi_feedback ?? '') }}</textarea>
                        @error('isi_feedback')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TOMBOL KIRIM DENGAN CSS MURNI DAN KONTRAST TINGGI --}}
                    <div class="pt-4" style="display: block !important;">
                        <button type="submit" 
                            style="
                                width: 100%; 
                                padding: 12px 24px; 
                                font-size: 1.125rem; /* text-lg */
                                font-weight: 600; /* font-semibold */
                                color: white !important; 
                                background-color: #EF4444 !important; /* Merah Menyala (bg-red-500) */
                                border-radius: 0.5rem; /* rounded-lg */
                                border: none;
                                cursor: pointer;
                                display: flex !important; 
                                align-items: center;
                                justify-content: center;
                                margin-top: 1rem;
                                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
                            ">
                            <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i> KIRIM / PERBARUI FEEDBACK (INI TOMBOLNYA)
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIWAYAT FEEDBACK --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h5 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-history mr-2 text-green-600"></i> Riwayat Feedback Anda (Total: {{ $riwayatFeedback->count() }})
                </h5>
            </div>
            <div class="p-4">
                @if ($riwayatFeedback->isEmpty())
                    <div class="p-4 text-center text-blue-800 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center shadow-sm">
                        <i class="fas fa-info-circle mr-2"></i> Anda belum memiliki riwayat pengiriman feedback.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden shadow-sm">
                            <thead class="bg-gradient-to-r from-green-100 to-teal-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester Ke-</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kirim</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi Feedback</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($riwayatFeedback as $feedback)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-200 text-green-800">
                                                {{ $feedback->semester_ke }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i> {{ $feedback->tanggal_input->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            <p class="text-dark mb-0">{{ Str::limit($feedback->isi_feedback, 100, '...') }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection