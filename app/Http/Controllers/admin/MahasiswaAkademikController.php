<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MahasiswaDetail;
use Illuminate\Support\Facades\DB;
use App\Imports\AkademikImport; // Asumsi Anda akan menggunakan library seperti Laravel Excel

class MahasiswaAkademikController extends Controller
{
    /**
     * Tampilkan halaman daftar nilai akademik seluruh mahasiswa (Data Mahasiswa).
     * Role: Admin, BPDPKS (Read Only)
     */
    public function index()
    {
        // Logika untuk mengambil data akademik seluruh mahasiswa
        $mahasiswaAkademik = MahasiswaDetail::with('user', 'kampus')->paginate(20);
        return view('admin.mahasiswa.akademik.index', compact('mahasiswaAkademik'));
    }

    /**
     * Tampilkan formulir untuk menginput nilai IPS/IPK per mahasiswa.
     * Role: Admin
     */
    public function create(MahasiswaDetail $mahasiswaDetail)
    {
        return view('admin.mahasiswa.akademik.create', compact('mahasiswaDetail'));
    }

    /**
     * Simpan nilai IPS/IPK yang diinput Admin (Manual Input).
     * Role: Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ipk' => 'required|numeric|min:0|max:4',
            'ips_terakhir' => 'required|numeric|min:0|max:4',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        $detail = MahasiswaDetail::where('user_id', $request->user_id)->firstOrFail();
        
        $detail->update([
            'ipk' => $request->ipk,
            'ips_terakhir' => $request->ips_terakhir,
        ]);

        return redirect()->route('admin.mahasiswa.akademik.index')->with('success', 'Nilai akademik berhasil diupdate.');
    }

    // --- Implementasi Fitur Mass Upload (Sesuai Saran) ---
    /**
     * Tampilkan formulir untuk upload file Excel/CSV (Mass Upload).
     * Role: Admin
     */
    public function showImportForm()
    {
        return view('admin.mahasiswa.akademik.import');
    }

    /**
     * Proses file Excel/CSV yang diupload (Mass Upload).
     * Role: Admin
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        // Catatan: Anda harus menginstal library Laravel Excel dan membuat file Import
        // try {
        //     (new AkademikImport)->import($request->file('file'));
        //     return redirect()->route('admin.akademik.index')->with('success', 'Mass Upload data akademik berhasil diproses.');
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        // }
        
        return back()->with('success', 'Fitur Mass Upload berhasil dipicu. Implementasi library Excel diperlukan.');
    }
}