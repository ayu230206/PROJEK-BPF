<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// PERBAIKAN: Sesuaikan import dengan namespace yang ada di file Model Anda
use App\Models\Admin\Pengumuman; 

class AdminNotifikasiController extends Controller
{
    /**
     * Tampilkan daftar Notifikasi/Pengumuman yang sudah dikirim.
     * Role: Admin
     */
    public function index()
    {
        $notifikasis = Notifikasi::latest()->paginate(10);
        // Pastikan path view ini benar sesuai struktur folder resources/views Anda
        // Jika folder viewnya "admin/notifikasi/index.blade.php", ubah path di bawah
        return view('admin.mahasiswa.Notifikasi dan Pengumuman.index', compact('notifikasis'));
    }

    /**
     * Tampilkan formulir untuk membuat pengumuman baru.
     * Role: Admin
     */
    public function create()
    {
        return view('admin.mahasiswa.Notifikasi dan Pengumuman.create');
    }

    /**
     * Simpan Notifikasi/Pengumuman baru dan kirim ke Mahasiswa.
     * Role: Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'jenis' => 'required|in:umum,pencairan,registrasi_ulang',
        ]);

        // Simpan ke database
        $notifikasi = Notifikasi::create(array_merge($request->all(), [
            'user_id_pengirim' => auth()->id(), // Admin yang mengirim
            // Default role penerima jika tidak ada di form
            'role_penerima' => 'mahasiswa', 
        ]));
        
        return redirect()->route('admin.notifikasi.index')->with('success', 'Pengumuman berhasil dibuat dan dikirim ke dashboard Mahasiswa.');
    }

    /**
     * Tampilkan formulir edit Notifikasi/Pengumuman.
     * Role: Admin
     */
    public function edit(Notifikasi $notifikasi)
    {
        return view('admin.mahasiswa.Notifikasi dan Pengumuman.edit', compact('notifikasi'));
    }

    /**
     * Perbarui Notifikasi/Pengumuman yang sudah ada.
     * Role: Admin
     */
    public function update(Request $request, Notifikasi $notifikasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'jenis' => 'required|in:umum,pencairan,registrasi_ulang',
        ]);

        $notifikasi->update($request->all());

        return redirect()->route('admin.notifikasi.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus Notifikasi/Pengumuman.
     * Role: Admin
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}