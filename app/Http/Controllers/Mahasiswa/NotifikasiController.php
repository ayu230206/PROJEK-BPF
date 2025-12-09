<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // Tampilkan semua notifikasi
    public function index()
    {
        $user = Auth::user();

        // Tandai semua notifikasi belum dibaca sebagai sudah dibaca
        $user->unreadNotifications->markAsRead();

        // Ambil semua notifikasi (gunakan property, bukan method)
        $notifikasi = $user->notifications; // ✅ property

        return view('mahasiswa.notifikasi.index', compact('notifikasi'));
    }

    // Hapus satu notifikasi
    public function destroy($id)
    {
        $user = Auth::user();
        $notif = $user->notifications->firstWhere('id', $id); // ambil dari property collection

        if ($notif) {
            $notif->delete();
            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    // Hapus semua notifikasi
    public function destroyAll()
    {
        $user = Auth::user();

        foreach ($user->notifications as $notif) {
            $notif->delete();
        }

        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
