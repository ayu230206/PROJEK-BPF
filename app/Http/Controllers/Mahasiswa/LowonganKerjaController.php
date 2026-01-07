<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// GANTI: Model lama mahasiswa dihapus
// use App\Models\Mahasiswa\LowonganKerja;
// use App\Models\Mahasiswa\Lamaran;

// PAKAI MODEL DARI BPDPKS
use App\Models\Bpdpks\Lowongan; 
use App\Models\Bpdpks\LowonganAplikasi;

class LowonganKerjaController extends Controller
{
    // Daftar lowongan kerja (search + pagination)
    public function index(Request $request)
    {
        $query = Lowongan::where('tipe', 'lowongan_kerja')
                         ->orderBy('deadline', 'desc');

        // Jika ada search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('perusahaan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $lowongans = $query->paginate(9);

        // Cek lowongan yang sudah dilamar
        $appliedLowonganIds = LowonganAplikasi::where('mahasiswa_id', Auth::id())
                                              ->pluck('lowongan_id')
                                              ->toArray();

        return view('mahasiswa.lowongankerja.index',
            compact('lowongans', 'appliedLowonganIds')
        );
    }

    // Detail lowongan
    public function show($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $sudahMelamar = LowonganAplikasi::where('lowongan_id', $id)
                                        ->where('mahasiswa_id', Auth::id())
                                        ->exists();

        return view('mahasiswa.lowongankerja.show',
            compact('lowongan', 'sudahMelamar')
        );
    }

    // Lamar lowongan
    public function lamar(Request $request, $id)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
            'portofolio' => 'nullable|file|max:5120',
        ]);

        $lowongan = Lowongan::findOrFail($id);

        // Cegah melamar 2x
        if (
            LowonganAplikasi::where('lowongan_id', $id)
                            ->where('mahasiswa_id', Auth::id())
                            ->exists()
        ) {
            return back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        $cvPath = $request->file('cv')->store('lamaran/cv', 'public');
        $portofolioPath = $request->hasFile('portofolio')
            ? $request->file('portofolio')->store('lamaran/portofolio', 'public')
            : null;

        LowonganAplikasi::create([
            'lowongan_id' => $id,
            'mahasiswa_id' => Auth::id(),
            'cv' => $cvPath,
            'portofolio' => $portofolioPath,
            'status' => 'diajukan',
        ]);

        return redirect()->route('mahasiswa.lowongankerja.index')
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    // Riwayat Lamaran
    public function riwayat()
    {
        $lamarans = LowonganAplikasi::where('mahasiswa_id', Auth::id())
            ->with('lowongan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.lowongankerja.riwayat', compact('lamarans'));
    }
}
