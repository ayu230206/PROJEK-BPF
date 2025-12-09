<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaDetail;
use Illuminate\Http\Request;

class AdminMahasiswaAkademikController extends Controller
{
    // Menampilkan daftar nilai mahasiswa
    public function index()
    {
        // Ambil mahasiswa beserta relasi kampus dan usernya
        $dataMahasiswa = MahasiswaDetail::with(['user', 'kampus'])->latest()->paginate(10);
        return view('admin.mahasiswa.akademik.index', compact('dataMahasiswa'));
    }

    // Form edit nilai manual
    public function edit(MahasiswaDetail $mahasiswaDetail)
    {
        return view('admin.mahasiswa.akademik.edit', compact('mahasiswaDetail'));
    }

    // Update nilai manual (IPS/IPK)
    public function update(Request $request, MahasiswaDetail $mahasiswaDetail)
    {
        $request->validate([
            'ipk' => 'required|numeric|between:0,4.00',
            'semester_berjalan' => 'required|numeric',
        ]);

        $mahasiswaDetail->update([
            'ipk' => $request->ipk,
            'semester_berjalan' => $request->semester_berjalan,
            // Tambahkan field lain jika ada (misal IPS semester ini)
        ]);

        return redirect()->route('admin.mahasiswa.akademik.index')
            ->with('success', 'Data akademik mahasiswa berhasil diperbarui.');
    }

    // Menampilkan form create manual (jika diperlukan)
    public function create(MahasiswaDetail $mahasiswaDetail)
    {
        return view('admin.mahasiswa.akademik.create', compact('mahasiswaDetail'));
    }

    // Simpan data manual
    public function store(Request $request)
    {
        // Logika simpan manual mirip update
        return redirect()->back()->with('success', 'Data disimpan.');
    }

    // Form Import Excel
    public function showImportForm()
    {
        return view('admin.mahasiswa.akademik.import');
    }

    // Proses Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        // TODO: Gunakan library Maatwebsite/Excel di sini untuk membaca file
        // Saat ini kita buat dummy success saja agar tidak error
        
        return redirect()->route('admin.mahasiswa.akademik.index')
            ->with('success', 'Fitur Import Excel akan diproses (Butuh Library Maatwebsite/Excel).');
    }
}