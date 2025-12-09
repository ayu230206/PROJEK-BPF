<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaDetail; 
use App\Models\Bpdpks\Kampus; 
use Illuminate\Http\Request;

class AdminDataMahasiswaController extends Controller
{
    /**
     * List semua mahasiswa. 
     * Logic filter adaptasi dari[cite: 23].
     */
    public function index(Request $request)
    {
        $query = MahasiswaDetail::with(['user', 'kampus']);

        // Search logic [cite: 24]
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search);
            })->orWhereHas('kampus', function ($q) use ($search) {
                $q->where('nama_kampus', 'like', $search);
            })->orWhere('nim', 'like', $search);
        }

        // Filter Kampus
        if ($request->filled('kampus_id')) {
            $query->where('kampus_id', $request->kampus_id);
        }

        $dataMahasiswa = $query->latest()->paginate(10);
        $allKampus = Kampus::orderBy('nama_kampus')->get();

        return view('admin.mahasiswa.index', compact('dataMahasiswa', 'allKampus'));
    }

    /**
     * Detail mahasiswa.
     * Logic adaptasi dari[cite: 30].
     */
    public function show(MahasiswaDetail $mahasiswa)
    {
        $mahasiswa->load(['user', 'kampus']);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }
}