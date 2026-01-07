<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
// Import Model yang sudah ada di namespace App\Models\Bpdpks\
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\LowonganAplikasi;
// Pastikan User Model diimport dari App\Models\
use App\Models\User;

class LowonganController extends Controller
{

    public function __construct() {}


    public function index(Request $request)
    {
        $tipe = $request->get('tipe', 'semua');
        $search = $request->get('search');

        $lowongans = Lowongan::withCount('aplikasi')
            // Relasi diinputOleh untuk menampilkan siapa yang membuat post
            ->with('diinputOleh')
            ->orderBy('deadline', 'desc');

        if ($tipe != 'semua') {
            $lowongans->where('tipe', $tipe);
        }

        if ($search) {
            $lowongans->where('judul', 'like', '%' . $search . '%');
        }

        $lowongans = $lowongans->paginate(10)->withQueryString();

        // Mengambil data aplikasi yang masih berstatus 'diajukan'
        $pendingAplikasiCount = LowonganAplikasi::where('status', 'diajukan')->count();

        // 

        return view('bpdpks.lowongan.index', compact('lowongans', 'tipe', 'search', 'pendingAplikasiCount'));
    }

    /**
     * Menampilkan formulir pembuatan Lowongan/Magang baru.
     */
    public function create()
    {
        return view('bpdpks.lowongan.create');
    }

    /**
     * Menyimpan data Lowongan/Magang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => ['required', Rule::in(['magang', 'lowongan_kerja'])],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
            // Tambahkan validasi untuk field baru:
            'lokasi' => 'nullable|string|max:255',
            'gaji' => 'nullable|string|max:255', // Asumsi gaji adalah string
            // End Tambahan
            'foto' => 'nullable|image|max:2048',
            'file_pendukung' => 'nullable|mimes:pdf|max:5120',
        ]);

        // ✅ PERBAIKAN UTAMA: Tambahkan 'lokasi' dan 'gaji'
        $data = $request->only([
            'tipe',
            'judul',
            'deskripsi',
            'kualifikasi',
            'deadline',
            'lokasi', // <= DITAMBAHKAN
            'gaji'    // <= DITAMBAHKAN
        ]);
        $data['diinput_oleh_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lowongan/foto', 'public');
        }
        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('lowongan/file', 'public');
        }

        Lowongan::create($data);

        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit Lowongan/Magang.
     */
    public function edit(Lowongan $lowongan)
    {
        return view('bpdpks.lowongan.edit', compact('lowongan'));
    }

    /**
     * Memperbarui data Lowongan/Magang.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'tipe' => ['required', Rule::in(['magang', 'lowongan_kerja'])],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
            // Tambahkan validasi untuk field baru:
            'lokasi' => 'nullable|string|max:255',
            'gaji' => 'nullable|string|max:255', // Asumsi gaji adalah string
            // End Tambahan
            'foto' => 'nullable|image|max:2048',
            'file_pendukung' => 'nullable|mimes:pdf|max:5120',
        ]);

        // ✅ PERBAIKAN UTAMA: Tambahkan 'lokasi' dan 'gaji'
        $data = $request->only([
            'tipe',
            'judul',
            'deskripsi',
            'kualifikasi',
            'deadline',
            'lokasi', // <= DITAMBAHKAN
            'gaji'    // <= DITAMBAHKAN
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lowongan/foto', 'public');
        }
        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('lowongan/file', 'public');
        }

        $lowongan->update($data);

        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * Menghapus data Lowongan/Magang.
     */
    public function destroy(Lowongan $lowongan)
    {
        // Tambahkan konfirmasi penghapusan (disarankan di sisi view/frontend)
        $lowongan->delete();
        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil dihapus!');
    }
    
    // --- MONITORING APLIKASI OLEH ADMIN/BPDPKS ---

    /**
     * Menampilkan daftar aplikasi yang masuk untuk Lowongan/Magang tertentu.
     */
    public function monitoringAplikasi(Request $request, Lowongan $lowongan)
    {
        // Pastikan hanya Admin/BPDPKS yang bisa mengakses
        if (!in_array(Auth::user()->role, ['admin', 'bpdpks'])) {
            abort(403, 'Akses ditolak.');
        }

        $status = $request->get('status', 'semua');

        $aplikasis = $lowongan->aplikasi()->with(['mahasiswa' => function ($query) {
            // PERBAIKAN: Mengganti 'detailMahasiswa' menjadi 'detail' 
            // karena di model User relasi tersebut bernama detail().
            $query->with('detail.kampus');
        }])
            ->orderBy('created_at', 'desc');

        if ($status != 'semua') {
            $aplikasis->where('status', $status);
        }

        $aplikasis = $aplikasis->paginate(10)->withQueryString();

        return view('bpdpks.lowongan.monitoring_aplikasi', compact('lowongan', 'aplikasis', 'status'));
    }

    /**
     * Memproses (Menerima/Menolak) aplikasi dari Mahasiswa.
     */
    public function prosesAplikasi(Request $request, LowonganAplikasi $aplikasidata)
    {
        // Pastikan hanya Admin/BPDPKS yang bisa mengakses
        if (!in_array(Auth::user()->role, ['admin', 'bpdpks'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => ['required', Rule::in(['diterima', 'ditolak'])],
            'catatan_admin' => 'nullable|string',
        ]);

        $aplikasidata->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);



        // Opsional: Kirim notifikasi kepada mahasiswa yang bersangkutan

        return redirect()->back()->with('success', 'Status aplikasi berhasil diperbarui!');
    }

    public function detailAplikasi(LowonganAplikasi $aplikasi)
    {
        // Pastikan hanya Admin/BPDPKS yang bisa mengakses
        if (!in_array(Auth::user()->role, ['admin', 'bpdpks'])) {
            abort(403, 'Akses ditolak.');
        }

        // Load relasi mahasiswa + kampus untuk mencegah N+1 Query
        $aplikasi->load([
            'mahasiswa.detail.kampus',
            'lowongan'
        ]);

        // Kirim variabel cv & portofolio ke view
        return view('bpdpks.lowongan.show', [
            'aplikasi' => $aplikasi,
            'cv' => $aplikasi->cv,
            'portofolio' => $aplikasi->portofolio
        ]);
    }
}
