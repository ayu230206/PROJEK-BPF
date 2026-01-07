<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Bpdpks\Kampus;
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\Keuangan;
use App\Models\MahasiswaDetail;
use App\Models\ActivityLog; // Pastikan ini diimport

class AdminDashboardController extends Controller
{
    public function index()
    {


        // 1. STATISTIK DATA
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $mahasiswaAktif = User::where('role', 'mahasiswa')->where('status_aktif', true)->count();
        $kampusKerjasama = Kampus::where('status_kerjasama', 'aktif')->count();
        $lowonganAktif = Lowongan::where('deadline', '>=', now())->count();
        
        // Dokumen Pending
        $dokumenPending = MahasiswaDetail::whereNull('path_ktp')->orWhereNull('path_kartu_mhs')->count();
        
        // Dana Tersalurkan
        $totalDana = Keuangan::whereIn('status_pencairan', ['diterima', 'ditransfer'])
                             ->sum(DB::raw('jumlah_bulanan + jumlah_buku'));

        $stats = [
            'total_mahasiswa' => $totalMahasiswa,
            'mahasiswa_aktif' => $mahasiswaAktif,
            'dana_tersalurkan' => 'Rp ' . number_format($totalDana, 0, ',', '.'),
            'kampus_kerjasama' => $kampusKerjasama,
            'lowongan_magang_aktif' => $lowonganAktif,
            'dokumen_perlu_verifikasi' => $dokumenPending,
            // Tambahan untuk view dashboard baru
            'bpdpks_online' => User::where('role', 'bpdpks')->where('status_aktif', true)->count(),
            'admin_online' => 1
        ];

        // 2. NOTIFIKASI TERBARU (Dari ActivityLog)
        // Mengambil 5 aktivitas terakhir
        $logs = ActivityLog::with('user')->latest()->take(5)->get();
        
        $notifications = $logs->map(function($log) {
            return [
                'title' => $log->action . ' oleh ' . $log->user->nama_lengkap,
                'link'  => '#', 
                'time'  => $log->created_at->diffForHumans(),
                'desc'  => $log->description
            ];
        });




        // 3. LOGO LOGIC
        $logoPath = 'images/default-logo.png';
        if (Storage::disk('public')->exists('settings/website_logo.png')) {
            $logoPath = 'storage/settings/website_logo.png';
        }

        return view('admin.Dashboard', compact('stats', 'logoPath', 'notifications'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $request->file('logo')->storeAs('settings', 'website_logo.png', 'public');
            
            // Catat Log
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Update Logo',
                'description' => 'Logo website diperbarui.'
            ]);

            return redirect()->back()->with('success', 'Logo website berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengupload logo.');
    }

    public function settings()
    {
        $logoPath = 'images/default-logo.png';
        if (Storage::disk('public')->exists('settings/website_logo.png')) {
            $logoPath = 'storage/settings/website_logo.png';
        }
        return view('admin.settings.index', compact('logoPath'));
    }
}