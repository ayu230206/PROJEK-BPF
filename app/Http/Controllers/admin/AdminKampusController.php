<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Kampus; 
use Illuminate\Http\Request;

class AdminKampusController extends Controller
{
    /**
     * Menampilkan daftar kampus (Versi Admin).
     * Logic filter diambil dari KampusKerjasamaController[cite: 90].
     */
    public function index(Request $request)
    {
        $query = Kampus::query();

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_kampus', 'like', $search)
                  ->orWhere('kode_kampus', 'like', $search);
            });
        }

        // Admin mungkin ingin melihat status kerjasama
        if ($request->filled('status')) {
            $query->where('status_kerjasama', $request->status);
        }

        $dataKampus = $query->latest()->paginate(10);
        
        // Return ke view folder admin
        return view('admin.kampus.index', compact('dataKampus'));
    }

    public function create()
    {
        return view('admin.kampus.create');
    }

    /**
     * Store kampus baru. Logic adaptasi dari[cite: 98].
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kampus' => 'required|unique:kampus,nama_kampus',
            'kode_kampus' => 'nullable|unique:kampus,kode_kampus',
            'status_kerjasama' => 'required|in:aktif,nonaktif,ditolak,pending', // Admin bisa set semua status
        ]);

        Kampus::create($validated);

        return redirect()->route('admin.kampus.index')->with('success', 'Kampus berhasil ditambahkan.');
    }

    public function edit(Kampus $kampus)
    {
        return view('admin.kampus.edit', compact('kampus'));
    }

    public function update(Request $request, Kampus $kampus)
    {
        $validated = $request->validate([
            'nama_kampus' => 'required|unique:kampus,nama_kampus,' . $kampus->id,
            'kode_kampus' => 'nullable|unique:kampus,kode_kampus,' . $kampus->id,
            'status_kerjasama' => 'required|in:aktif,nonaktif,ditolak,pending',
        ]);

        $kampus->update($validated);

        return redirect()->route('admin.kampus.index')->with('success', 'Kampus berhasil diperbarui.');
    }

    public function destroy(Kampus $kampus)
    {
        // Validasi relasi mahasiswa seperti di [cite: 114]
        if ($kampus->mahasiswa()->exists()) {
            return back()->with('error', 'Gagal hapus, masih ada mahasiswa di kampus ini.');
        }
        
        $kampus->delete();
        return redirect()->route('admin.kampus.index')->with('success', 'Kampus dihapus.');
    }
}