<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\LowonganKerja;
use App\Models\Mahasiswa\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganKerjaController extends Controller
{
    // Daftar lowongan dengan search + pagination
    public function index(Request $request)
    {
        $query = LowonganKerja::query();

        // Jika ada keyword search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('perusahaan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        // Order terbaru dan paginate 9 per halaman
        $lowongans = $query->orderBy('tanggal_post', 'desc')->paginate(9);

        return view('mahasiswa.lowongankerja.index', compact('lowongans'));
    }

    // Detail lowongan + form lamaran
    public function show($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        return view('mahasiswa.lowongankerja.show', compact('lowongan'));
    }

    // Submit lamaran
    public function lamar(Request $request, $id)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
            'portofolio' => 'nullable|file|max:5120',
        ]);

        $lowongan = LowonganKerja::findOrFail($id);

        $cvPath = $request->file('cv')->store('lamaran/cv', 'public');
        $portofolioPath = $request->hasFile('portofolio')
            ? $request->file('portofolio')->store('lamaran/portofolio', 'public')
            : null;

        Lamaran::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $lowongan->lowongan_id,
            'cv' => $cvPath,
            'portofolio' => $portofolioPath,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.lowongankerja.index')
                         ->with('success', 'Lamaran berhasil dikirim!');
    }

    // Riwayat lamaran
    public function riwayat()
    {
        $lamarans = Lamaran::where('user_id', Auth::id())
            ->with('lowongan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.lowongankerja.riwayat', compact('lamarans'));
    }
}
