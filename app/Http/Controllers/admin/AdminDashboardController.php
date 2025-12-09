<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Import Model
use App\Models\User;
use App\Models\Bpdpks\Kampus;
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\Keuangan; // Pastikan Model Keuangan diimport
use App\Models\MahasiswaDetail; // Untuk dokumen pending

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. DATA REAL DARI DATABASE
        
        // Menghitung total user dengan role mahasiswa
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        // Menghitung mahasiswa aktif (status_aktif = true)
        $mahasiswaAktif = User::where('role', 'mahasiswa')
                              ->where('status_aktif', true)
                              ->count();

        // Menghitung Kampus yang status kerjasamanya 'aktif'
        $kampusKerjasama = Kampus::where('status_kerjasama', 'aktif')->count();

        // Menghitung Lowongan Magang/Kerja yang belum kedaluwarsa
        $lowonganAktif = Lowongan::where('deadline', '>=', now())->count();

        // Menghitung Dokumen Pending (Logika: Ambil mahasiswa yang dokumennya belum lengkap/verified)
        // Asumsi: di MahasiswaDetail ada kolom check dokumen, atau kita hitung user baru
        // Disini kita hitung mahasiswa yang belum punya path_ktp sebagai contoh "Perlu Verifikasi"
        $dokumenPending = MahasiswaDetail::whereNull('path_ktp')
                                         ->orWhereNull('path_kartu_mhs')
                                         ->count();

        // Hitung Total Dana Tersalurkan (Status = diterima/ditransfer)
        // Menjumlahkan uang bulanan + uang buku
        $totalDana = Keuangan::whereIn('status_pencairan', ['diterima', 'ditransfer'])
                             ->sum(DB::raw('jumlah_bulanan + jumlah_buku'));

        // Masukkan ke array stats
        $stats = [
            'total_mahasiswa' => $totalMahasiswa,
            'mahasiswa_aktif' => $mahasiswaAktif,
            'dana_tersalurkan' => 'Rp ' . number_format($totalDana, 0, ',', '.'),
            'kampus_kerjasama' => $kampusKerjasama,
            'lowongan_magang_aktif' => $lowonganAktif,
            'dokumen_perlu_verifikasi' => $dokumenPending,
        ];

        // 2. NOTIFIKASI AKTIVITAS TERBARU (Real Data)
        // Mengambil 5 User mahasiswa yang baru mendaftar
        $latestUsers = User::where('role', 'mahasiswa')
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        
        $notifications = [];
        foreach($latestUsers as $user) {
            $notifications[] = [
                'title' => "Mahasiswa baru: {$user->nama_lengkap}",
                'time'  => $user->created_at->diffForHumans(),
                // Link menuju detail mahasiswa tersebut
                'link'  => $user->detail ? route('admin.mahasiswa.data.show', $user->detail->id) : '#' 
            ];
        }

        // Jika kosong
        if (count($notifications) == 0) {
             $notifications[] = [
                'title' => 'Tidak ada aktivitas baru.',
                'time'  => '-',
                'link'  => '#'
            ];
        }

        $adminName = Auth::user()->nama_lengkap ?? 'Administrator';
        
        // Logo Logic
        $logoPath = 'images/default-logo.png';
        if (Storage::disk('public')->exists('settings/website_logo.png')) {
            $logoPath = 'storage/settings/website_logo.png';
        }

        return view('admin.Dashboard', compact('stats', 'notifications', 'adminName', 'logoPath'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $request->file('logo')->storeAs('settings', 'website_logo.png', 'public');
            return redirect()->back()->with('success', 'Logo website berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengupload logo.');
    }

    public function settings()
    {
        // Cek apakah ada logo tersimpan
        $logoPath = 'images/default-logo.png';
        if (Storage::disk('public')->exists('settings/website_logo.png')) {
            $logoPath = 'storage/settings/website_logo.png';
        }

        return view('admin.settings.index', compact('logoPath'));
    }
}