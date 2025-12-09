<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\RegistrasiUlang; // Model Registrasi Ulang
use App\Models\User;            // Model User (Mahasiswa)

class AdminRegisUlangController extends Controller
{
    /**
     * Menampilkan daftar permohonan Registrasi Ulang.
     * Mengambil data dari tabel registrasi_ulang.
     */
    public function index()
    {
        // Mengambil semua permohonan Registrasi Ulang dengan relasi User
        $dataRegis = RegistrasiUlang::with('user')
                                    ->latest()
                                    ->paginate(10); 
                                    
        // Catatan: Variabel $dataRegis akan digunakan di view regis-ulang/index.blade.php
        return view('admin.regis-ulang.index', compact('dataRegis'));
    }

    /**
     * Aksi: Menyetujui Permohonan Registrasi Ulang.
     */
    public function approve($id)
    {
        $regis = RegistrasiUlang::findOrFail($id);
        
        // 1. Cek Syarat Kritis sebelum Approve
        if (!$regis->sudah_feedback || !$regis->syarat_nilai_terpenuhi) {
            return back()->with('error', 'Gagal menyetujui! Syarat Feedback atau Nilai belum terpenuhi.');
        }

        // 2. Update Status Registrasi
        $regis->update([
            'status_regis' => 'disetujui',
            // Opsional: tambahkan catatan Admin jika ada
        ]);
        
        // 3. Update Status Aktif Mahasiswa (Asumsi: di tabel users)
        if ($regis->user) {
            $regis->user->update(['status_aktif' => true]);
        }

        return redirect()->route('admin.regis-ulang.index')->with('success', 'Registrasi Ulang berhasil disetujui.');
    }

    /**
     * Aksi: Menolak Permohonan Registrasi Ulang.
     */
    public function reject($id)
    {
        $regis = RegistrasiUlang::findOrFail($id);
        
        // Update Status Registrasi
        $regis->update([
            'status_regis' => 'ditolak',
            // Tambahkan kolom alasan_penolakan jika ada di model
        ]);
        
        // Opsional: Nonaktifkan Mahasiswa jika ditolak
        if ($regis->user) {
             $regis->user->update(['status_aktif' => false]);
        }

        return redirect()->route('admin.regis-ulang.index')->with('success', 'Registrasi Ulang berhasil ditolak.');
    }
}