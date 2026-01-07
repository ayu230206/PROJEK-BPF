<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Kampus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KampusKerjasamaController extends Controller
{
    /**
     * Menampilkan daftar kampus.
     */
    public function index(Request $request)
    {
        $query = Kampus::query();

        // Filter berdasarkan nama/kode kampus
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_kampus', 'like', $search)
                    ->orWhere('kode_kampus', 'like', $search);
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status_aktif')) {
            // Mapping status dari view (aktif/nonaktif) ke nilai enum di DB (aktif/ditolak)
            $statusDb = $request->status_aktif == 'aktif' ? 'aktif' : 'ditolak';
            $query->where('status_kerjasama', $statusDb);
        }

        // Ambil data dengan pagination
        $dataKampus = $query->latest()->paginate(10);

        return view('bpdpks.kerjasama.index', compact('dataKampus'));
    }

    /**
     * Menampilkan form tambah kampus.
     */
    public function create()
    {
        return view('bpdpks.kerjasama.create');
    }

    /**
     * Menyimpan data kampus baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kampus' => 'required|string|max:255|unique:kampus,nama_kampus',
            'kode_kampus' => 'nullable|string|max:20|unique:kampus,kode_kampus',
            'alamat' => 'nullable|string',
            'nomor_mou' => 'nullable|string|max:100',
            'tanggal_mou' => 'nullable|date',
            'status_aktif' => 'required|boolean', // Status dari form
        ]);

        // Mapping status_aktif (0/1 dari form) ke status_kerjasama (enum dari DB)
        $statusKerjasama = $validatedData['status_aktif'] == 1 ? 'aktif' : 'ditolak';

        // Gabungkan data request dengan status yang sudah diconvert
        $dataToCreate = array_merge($validatedData, [
            'status_kerjasama' => $statusKerjasama,
        ]);

        // Hapus status_aktif dari array karena kolom tersebut tidak ada di DB
        unset($dataToCreate['status_aktif']);

        // Kita gunakan Kampus::create() dengan data yang sudah di mapping
        Kampus::create($dataToCreate);

        return redirect()->route('bpdpks.kerjasama.index')->with('success', 'Data kampus baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kampus.
     */
    public function edit(Kampus $kerjasama) // Menggunakan model binding
    {
        // Membuat properti virtual status_aktif (1/0) untuk digunakan di form edit
        $kerjasama->status_aktif = $kerjasama->status_kerjasama == 'aktif' ? '1' : '0';

        return view('bpdpks.kerjasama.edit', compact('kerjasama'));
    }

    /**
     * Memperbarui data kampus.
     */
    public function update(Request $request, Kampus $kerjasama) // Menggunakan model binding
    {
        $validatedData = $request->validate([
            'nama_kampus' => 'required|string|max:255|unique:kampus,nama_kampus,' . $kerjasama->id,
            'kode_kampus' => 'nullable|string|max:20|unique:kampus,kode_kampus,' . $kerjasama->id,
            'alamat' => 'nullable|string',
            'nomor_mou' => 'nullable|string|max:100',
            'tanggal_mou' => 'nullable|date',
            'status_aktif' => 'required|boolean', // Status dari form (0 atau 1)
        ]);

        // Mapping status_aktif (0/1 dari form) ke status_kerjasama (enum dari DB)
        $statusKerjasama = $validatedData['status_aktif'] == 1 ? 'aktif' : 'ditolak';

        // Buat array untuk update
        $dataToUpdate = [
            'nama_kampus' => $validatedData['nama_kampus'],
            'kode_kampus' => $validatedData['kode_kampus'],
            'alamat' => $validatedData['alamat'],
            'nomor_mou' => $validatedData['nomor_mou'],
            'tanggal_mou' => $validatedData['tanggal_mou'],
            // Menggunakan kolom DB yang benar (status_kerjasama)
            'status_kerjasama' => $statusKerjasama,
        ];

        // Update data
        $kerjasama->update($dataToUpdate);

        return redirect()->route('bpdpks.kerjasama.index')->with('success', 'Data kampus berhasil diperbarui!');
    }

    /**
     * Menghapus data kampus.
     */
    public function destroy(Kampus $kerjasama) // Menggunakan model binding
    {
        // Periksa apakah kampus memiliki mahasiswa terdaftar
        if (method_exists($kerjasama, 'mahasiswa') && $kerjasama->mahasiswa()->exists()) {
            return redirect()->route('bpdpks.kerjasama.index')->with('error', 'Gagal menghapus! Kampus ini masih memiliki mahasiswa terdaftar.');
        }

        $kerjasama->delete();

        return redirect()->route('bpdpks.kerjasama.index')->with('success', 'Data kampus berhasil dihapus!');
    }
}
