<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PenelitianLomba;

class PenelitianLombaController extends Controller
{
    /**
     * Tampilkan daftar Penelitian dan Lomba.
     * Role: Admin
     */
    public function index()
    {
        // Variabel yang digunakan di views harus konsisten. Menggunakan 'data' atau 'program'
        // Saya akan menggunakan 'data' sesuai kode Anda, tetapi pastikan view index Anda menggunakan nama yang sama.
        $dataPenelitianLomba = PenelitianLomba::latest()->paginate(10);
        // Note: Pada jawaban sebelumnya, view index menggunakan variabel $dataPenelitianLomba, 
        // pastikan Anda menyesuaikan di salah satu tempat. Saya menggunakan 'data' di controller ini.
        return view('admin.mahasiswa.penelitian dan lomba.index', compact('dataPenelitianLomba')); 
    }

    /**
     * Tampilkan formulir untuk membuat entri baru (Penelitian/Lomba).
     * Role: Admin
     */
    public function create()
    {
        return view('admin.mahasiswa.penelitian dan lomba.create');
    }

    /**
     * Simpan data Penelitian/Lomba baru.
     * Role: Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:penelitian,lomba',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penyelenggara' => 'nullable|string|max:255',
        ]);

        PenelitianLomba::create($request->all());

        // Mengarahkan ke route index yang benar
        return redirect()->route('admin.penelitian-lomba.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit data Penelitian/Lomba.
     * Role: Admin
     */
    public function edit(PenelitianLomba $penelitianLomba)
    {
        return view('admin.mahasiswa.penelitian dan lomba.edit', compact('penelitianLomba'));
    }

    /**
     * Perbarui data Penelitian/Lomba yang sudah ada.
     * Role: Admin
     */
    public function update(Request $request, PenelitianLomba $penelitianLomba)
    {
        $request->validate([
            'tipe' => 'required|in:penelitian,lomba',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penyelenggara' => 'nullable|string|max:255',
        ]);

        $penelitianLomba->update($request->all());

        return redirect()->route('admin.penelitian-lomba.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Hapus data Penelitian/Lomba.
     * Role: Admin
     */
    public function destroy(PenelitianLomba $penelitianLomba)
    {
        $penelitianLomba->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}