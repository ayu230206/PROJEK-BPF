@extends('mahasiswa.layouts.app')
@section('title', 'Pengajuan Magang')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 max-w-6xl mx-auto py-8">
    {{-- CARD RIWAYAT --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-green-200 overflow-hidden">

        <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-xl flex items-center gap-3">
            <span class="text-3xl">📋</span> Riwayat Pendaftaran Magang
        </div>

        <div class="p-8 overflow-x-auto">
            <table class="w-full text-sm text-center rounded-2xl shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-green-700 to-green-600 text-white">
                        <th class="p-4">#</th>
                        <th class="p-4">Tempat</th>
                        <th class="p-4">Posisi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">File</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($magangs as $item)
                        <tr class="border-b hover:bg-green-50">

                            <td class="p-4">{{ $loop->iteration }}</td>
                            <td class="p-4 font-semibold">{{ $item->tempat_magang }}</td>
                            <td class="p-4">{{ $item->posisi }}</td>

                            {{-- ✅ STATUS BARU FINAL --}}
                            <td class="p-4">
                                @if($item->status_pengajuan == 'proses')
                                    <span class="bg-yellow-400 text-white px-4 py-2 rounded-full text-xs font-semibold">
                                        Diproses
                                    </span>
                                @elseif($item->status_pengajuan == 'diterima')
                                    <span class="bg-green-500 text-white px-4 py-2 rounded-full text-xs font-semibold">
                                        Diterima
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white px-4 py-2 rounded-full text-xs font-semibold">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">{{ $item->tanggal_pengajuan }}</td>

                            <td class="p-4">
                                @if($item->file_pendukung)
                                    <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank"
                                        class="text-blue-600 font-semibold">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-gray-500 text-center bg-gray-50">
                                Belum ada pengajuan magang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
