<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BeasiswaProgram; // Asumsi Model BeasiswaProgram ada

class DataBeasiswaController extends Controller
{
    /**
     * Tampilkan daftar Program Beasiswa yang sudah dibuat.
     * Role: Admin
     */
    public function index()
    {
        // Menggunakan nama variabel 'programs' agar sesuai dengan standar views
        $programs = BeasiswaProgram::latest()->paginate(10);
        return view('admin.beasiswa.index', compact('programs'));
    }

    /**
     * Tampilkan formulir untuk membuat program beasiswa baru.
     * Role: Admin
     */
    public function create()
    {
        return view('admin.beasiswa.create');
    }

    /**
     * Simpan data Program Beasiswa baru ke database.
     * Role: Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_informasi' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            // TODO: Tambahkan validasi untuk path_banner_poster & path_dokumen_panduan jika ada file upload
        ]);

        BeasiswaProgram::create(array_merge($request->all(), [
            'created_by_user_id' => auth()->id(),
            // TODO: Logika upload file jika ada
        ]));

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program Beasiswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit program beasiswa.
     * Metode ini akan berinteraksi dengan view 'edit.blade.php' yang Anda berikan.
     * Role: Admin
     */
    public function edit(BeasiswaProgram $program)
    {
        return view('admin.beasiswa.edit', compact('program'));
    }

    /**
     * Perbarui data Program Beasiswa yang sudah ada.
     * Role: Admin
     */
    public function update(Request $request, BeasiswaProgram $program)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_informasi' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            // TODO: Tambahkan validasi dan logika update file jika ada
        ]);

        $program->update($request->all());

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program Beasiswa berhasil diperbarui.');
    }

    /**
     * Hapus data Program Beasiswa.
     * Role: Admin
     */
    public function destroy(BeasiswaProgram $program)
    {
        $program->delete();
        return back()->with('success', 'Program Beasiswa berhasil dihapus.');
    }
}