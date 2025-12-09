<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bpdpks\Lowongan; // <-- GANTI: Import Model Lowongan BPDPKS
use App\Models\Bpdpks\LowonganAplikasi; // Tambahkan jika butuh check aplikasi

class LowonganMagangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua lowongan/magang yang tipe-nya 'magang'
        $lowonganQuery = Lowongan::where('tipe', 'magang')
                            ->orderBy('deadline', 'desc');

        // Opsional: Hanya tampilkan yang deadline-nya belum lewat
        $lowonganQuery->where(function ($query) {
            $query->whereNull('deadline')
                  ->orWhere('deadline', '>=', now());
        });
        
        $lowongan = $lowonganQuery->get();

        // Ambil ID lowongan yang sudah dilamar oleh user yang sedang login
        $appliedLowonganIds = LowonganAplikasi::where('mahasiswa_id', auth()->id())
                                                ->pluck('lowongan_id')
                                                ->toArray();

        return view('mahasiswa.magang.lowongan', compact('lowongan', 'appliedLowonganIds'));
    }

    public function show($id)
    {
        // Gunakan Lowongan Model dari BPDPKS
        $lowongan = Lowongan::findOrFail($id); 

        // Cek apakah mahasiswa sudah melamar
        $sudahMelamar = LowonganAplikasi::where('lowongan_id', $lowongan->id)
                                        ->where('mahasiswa_id', auth()->id())
                                        ->exists();

        return view('mahasiswa.magang.lowongan_show', compact('lowongan', 'sudahMelamar'));
    }

    // Tambahkan fungsi untuk Melamar
    public function apply(Lowongan $lowongan)
    {
        // Validasi, pastikan belum pernah melamar
        if (LowonganAplikasi::where('lowongan_id', $lowongan->id)
                            ->where('mahasiswa_id', auth()->id())
                            ->exists()) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        // Simpan data aplikasi
        LowonganAplikasi::create([
            'lowongan_id' => $lowongan->id,
            'mahasiswa_id' => auth()->id(), // ID mahasiswa yang sedang login
            'status' => 'diajukan', // Default status
        ]);

        return redirect()->route('mahasiswa.magang.lowongan')->with('success', 'Berhasil melamar **' . $lowongan->judul . '**. Tunggu proses verifikasi dari admin.');
    }
}