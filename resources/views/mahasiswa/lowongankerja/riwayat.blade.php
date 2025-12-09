@extends('mahasiswa.layouts.app')

@section('title', 'Riwayat Lamaran Kerja')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-green-900 mb-6">Riwayat Lamaran Kerja</h1>

    <div class="bg-white p-5 border border-green-200 shadow rounded-lg">
        @if($lamarans->isEmpty())
            <p class="text-gray-500 italic">Belum ada lamaran.</p>
        @else
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-green-100 text-green-900">
                        <th class="px-4 py-2 text-left">Lowongan</th>
                        <th class="px-4 py-2 text-left">Perusahaan</th>
                        <th class="px-4 py-2 text-left">Tanggal Lamar</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lamarans as $lamaran)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $lamaran->lowongan->judul }}</td>
                            <td class="px-4 py-2">{{ $lamaran->lowongan->perusahaan }}</td>
                            <td class="px-4 py-2">{{ $lamaran->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                @if($lamaran->status == 'pending')
                                    <span class="text-yellow-600 font-semibold">Menunggu</span>
                                @elseif($lamaran->status == 'accepted')
                                    <span class="text-green-600 font-semibold">Diterima</span>
                                @elseif($lamaran->status == 'rejected')
                                    <span class="text-red-600 font-semibold">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
