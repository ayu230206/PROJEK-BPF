<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
// Import Model yang sudah ada di namespace App\Models\Bpdpks\
use App\Models\Admin\Lowongan;
use App\Models\Admin\LowonganAplikasi;
// Pastikan User Model diimport dari App\Models\
use App\Models\User; 

class LowonganController extends Controller
{
    /**
     * Pastikan hanya Admin atau BPDPKS yang dapat mengakses fitur ini (CRUD Lowongan).
     */
    public function __construct()
    {
        // ASUMSI: Anda telah membuat Middleware untuk Role checking (misalnya, via Spatie Permissions atau custom middleware)
        $this->middleware('auth');
        $this->middleware('role:admin,bpdpks'); 
    }

    // --- CRUD LOWONGAN/MAGANG (ADMIN/BPDPKS VIEW) ---

    /**
     * Menampilkan daftar Lowongan/Magang dan statistik aplikasi pending.
     */
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

        return view('admin.lowongan.index', compact('lowongans', 'tipe', 'search', 'pendingAplikasiCount'));
    }

    /**
     * Menampilkan formulir pembuatan Lowongan/Magang baru.
     */
    public function create()
    {
        return view('admin.lowongan.create');
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
            'deadline' => 'nullable|date|after_or_equal:today', // Deadline harus hari ini atau setelahnya
        ]);

        Lowongan::create([
            'tipe' => $request->tipe,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'diinput_oleh_id' => Auth::id(), // ID Admin/BPDPKS yang sedang login
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit Lowongan/Magang.
     */
    public function edit(Lowongan $lowongan)
    {
        return view('admin.lowongan.edit', compact('lowongan'));
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
        ]);

        $lowongan->update($request->only(['tipe', 'judul', 'deskripsi', 'kualifikasi', 'deadline']));

        return redirect()->route('admin.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil diperbarui!');
    }

    /**
     * Menghapus data Lowongan/Magang.
     */
    public function destroy(Lowongan $lowongan)
    {
        // Tambahkan konfirmasi penghapusan (disarankan di sisi view/frontend)
        $lowongan->delete();
        return redirect()->route('admin.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil dihapus!');
    }
    
    // --- MONITORING APLIKASI OLEH ADMIN/BPDPKS ---

    /**
     * Menampilkan daftar aplikasi yang masuk untuk Lowongan/Magang tertentu.
     */
    public function monitoringAplikasi(Request $request, Lowongan $lowongan)
    {
        // Pastikan hanya Admin/BPDPKS yang bisa mengakses
        if (!in_array(Auth::user()->role, ['admin', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        $status = $request->get('status', 'semua');

        $aplikasis = $lowongan->aplikasi()->with(['mahasiswa' => function ($query) {
            // Load detail mahasiswa (NIM, Kampus, Prodi)
            $query->with('detailMahasiswa.kampus'); 
        }])
            ->orderBy('created_at', 'desc');

        if ($status != 'semua') {
            $aplikasis->where('status', $status);
        }

        $aplikasis = $aplikasis->paginate(10)->withQueryString();

        return view('admin.lowongan.monitoring_aplikasi', compact('lowongan', 'aplikasis', 'status'));
    }

    /**
     * Memproses (Menerima/Menolak) aplikasi dari Mahasiswa.
     */
    public function prosesAplikasi(Request $request, LowonganAplikasi $aplikasidata)
    {
        // Pastikan hanya Admin/BPDPKS yang bisa mengakses
        if (!in_array(Auth::user()->role, ['admin', 'admin'])) {
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
}