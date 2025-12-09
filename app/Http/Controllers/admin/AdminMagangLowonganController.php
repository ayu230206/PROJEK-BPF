<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Lowongan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMagangLowonganController extends Controller
{
    public function index()
    {
        // Menampilkan lowongan urut terbaru, dengan data pembuatnya (User)
        $lowongans = Lowongan::with('diinputOleh')->latest()->paginate(10);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        return view('admin.lowongan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:magang,lowongan_kerja',
            'deskripsi' => 'required',
            'kualifikasi' => 'nullable|string', // Tambahan sesuai view
            'deadline' => 'required|date',
        ]);

        // Otomatis set ID user yang sedang login (Admin atau BPDPKS)
        $validated['diinput_oleh_id'] = Auth::id();
        // Set status default (misal: aktif/buka) jika ada kolom status
        $validated['status'] = 'aktif'; 
        
        Lowongan::create($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dipublish.');
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        return view('admin.lowongan.edit', compact('lowongan'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:magang,lowongan_kerja',
            'deskripsi' => 'required',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        // Opsional: Jika ingin mencatat siapa yang TERAKHIR mengubah, 
        // Anda perlu kolom 'updated_by_id' di tabel database.
        // Jika tidak, biarkan 'diinput_oleh_id' tetap milik pembuat asli.
        
        $lowongan->update($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan diperbarui.');
    }

    public function destroy($id)
    {
        Lowongan::destroy($id);
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan dihapus.');
    }
}