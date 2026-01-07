<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\LowonganAplikasi;

class LowonganMagangController extends Controller
{
    public function index(Request $request)
    {
        $lowonganQuery = Lowongan::where('tipe', 'magang')
                            ->orderBy('deadline', 'desc');

        $lowonganQuery->where(function ($query) {
            $query->whereNull('deadline')
                  ->orWhere('deadline', '>=', now());
        });

        $lowongan = $lowonganQuery->get();

        $appliedLowonganIds = LowonganAplikasi::where('mahasiswa_id', auth()->id())
                                                ->pluck('lowongan_id')
                                                ->toArray();

        return view('mahasiswa.magang.lowongan', compact('lowongan', 'appliedLowonganIds'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $sudahMelamar = LowonganAplikasi::where('lowongan_id', $id)
                                        ->where('mahasiswa_id', auth()->id())
                                        ->exists();

        return view('mahasiswa.magang.lowongan_show', compact('lowongan', 'sudahMelamar'));
    }

    // ====================================
    //  FUNCTION APPLY SUDAH DITINGKATKAN
    // ====================================
    public function apply(Request $request, Lowongan $lowongan)
    {
        // Validasi Upload
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
            'portofolio' => 'nullable|file|max:5120',
        ]);

        // Cegah melamar dua kali
        if (LowonganAplikasi::where('lowongan_id', $lowongan->id)
                            ->where('mahasiswa_id', auth()->id())
                            ->exists()) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        // Simpan file
        $cvPath = $request->file('cv')->store('lamaran/cv', 'public');
        $portofolioPath = $request->hasFile('portofolio')
            ? $request->file('portofolio')->store('lamaran/portofolio', 'public')
            : null;

        // Simpan aplikasi
        LowonganAplikasi::create([
            'lowongan_id' => $lowongan->id,
            'mahasiswa_id' => auth()->id(),
            'cv' => $cvPath,
            'portofolio' => $portofolioPath,
            'status' => 'diajukan',
        ]);

        return redirect()->route('mahasiswa.magang.lowongan')
                        ->with('success', 'Lamaran berhasil dikirim!');
    }
}
