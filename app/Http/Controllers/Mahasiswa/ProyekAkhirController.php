<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\ProyekAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa\BankJudulProyek;


class ProyekAkhirController extends Controller
{
    // METHOD BARU: Untuk menampilkan menu utama/dashboard ringkasan
    public function menu()
    {
        // PERBAIKAN: Mengganti view 'menu' menjadi 'dashboard'
        return view('mahasiswa.proyek.dashboard');
    }

    // Tampilkan semua proyek user saat ini (INDEX - Tabel Riwayat)
    public function index()
    {
        $projects = ProyekAkhir::where('user_id', Auth::id())->get();
        return view('mahasiswa.proyek.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'pembimbing' => 'nullable|string|max:255',
            'status_proyek' => 'nullable|in:pending,on_progress,completed',
            'tahun' => 'nullable|integer',
        ]);

        ProyekAkhir::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'pembimbing' => $request->pembimbing,
            'status_proyek' => $request->status_proyek ?? 'pending',  // ⭐ FIX WAJIB
            'tahun' => $request->tahun,
        ]);

        return back()->with('success', 'Proyek berhasil ditambah');
    }


    // METHOD EDIT (Dibutuhkan oleh Route)
    public function edit($id)
    {
        $proj = ProyekAkhir::findOrFail($id);
        if ($proj->user_id != Auth::id()) return back()->with('error', 'Akses ditolak.');
        return view('mahasiswa.proyek.edit', compact('proj'));
    }

    public function update(Request $request, $id)
    {
        $proj = ProyekAkhir::findOrFail($id);

        if ($proj->user_id != Auth::id()) return back();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'pembimbing' => 'nullable|string|max:255',
            'status_proyek' => 'required|in:pending,on_progress,completed',
            'tahun' => 'nullable|integer',
        ]);

        $proj->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'pembimbing' => $request->pembimbing,
            'status_proyek' => $request->status_proyek,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('mahasiswa.proyek.index')->with('success', 'Proyek diperbarui');
    }

    public function destroy($id)
    {
        $proj = ProyekAkhir::findOrFail($id);

        if ($proj->user_id != Auth::id()) return back();

        $proj->delete();

        return back()->with('success', 'Proyek dihapus');
    }
    public function bankJudul()
    {
        $judul = BankJudulProyek::latest()->get();
        return view('mahasiswa.proyek.bank-judul-proyek-akhir', compact('judul'));
    }
}
