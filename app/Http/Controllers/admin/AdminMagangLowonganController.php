<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Lowongan;
use App\Models\ActivityLog; // Import Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMagangLowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::with('diinputOleh')->latest()->paginate(10);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        return view('admin.lowongan.create');
    }

    public function store(Request $request)
    {
        // Validasi ditambah file_pendukung
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:magang,lowongan_kerja',
            'deskripsi' => 'required',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'required|date',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        // Upload File ke folder public/uploads/
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan langsung ke public path agar mudah diakses
            $file->move(public_path('uploads'), $filename);
            $validated['file_path'] = 'uploads/' . $filename;
        }

        $validated['diinput_oleh_id'] = Auth::id();
        $validated['status'] = 'aktif';

        Lowongan::create($validated);

        // Catat Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Tambah Lowongan',
            'description' => 'Menambahkan lowongan baru: ' . $request->judul
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dipublish.');
    }

    // ... method edit, update, destroy (sesuaikan logikanya jika perlu) ...
    public function destroy($id)
    {
        Lowongan::destroy($id);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Hapus Lowongan',
            'description' => 'Menghapus data lowongan ID: ' . $id
        ]);
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan dihapus.');
    }
}