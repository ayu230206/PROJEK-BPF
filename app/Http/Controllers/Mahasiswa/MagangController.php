<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifUmum;

class MagangController extends Controller
{
    public function index()
    {
        $magangs = Magang::where('user_id', Auth::id())->get();
        return view('mahasiswa.magang.riwayat', compact('magangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tempat_magang' => 'required',
            'posisi' => 'required',
            'file_pendukung' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $data = $request->only([
            'tempat_magang',
            'posisi',
            'deskripsi',
            'mulai',
            'selesai'
        ]);

        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('magang/file', 'public');
        }

        $data['user_id'] = Auth::id();

        // ✅ STATUS AWAL = PROSES (MENUNGGU PERSETUJUAN BPDPKS)
        $data['status_pengajuan'] = 'proses';

        $data['tanggal_pengajuan'] = now();

        Magang::create($data);

        // ✅ NOTIFIKASI
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Pengajuan Magang',
            'Pengajuan magang kamu berhasil dikirim & sedang diproses',
            url('/notifikasi')
        ));

        return back()->with('success', 'Pengajuan magang berhasil dikirim');
    }

    public function update(Request $request, $id)
    {
        $magang = Magang::where('magang_id', $id)->firstOrFail();

        // ✅ HANYA BOLEH EDIT JIKA MASIH PROSES
        if ($magang->user_id != Auth::id() || $magang->status_pengajuan != 'proses') {
            return back();
        }

        $request->validate([
            'tempat_magang' => 'required',
            'posisi' => 'required',
            'file_pendukung' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only([
            'tempat_magang',
            'posisi',
            'deskripsi',
            'mulai',
            'selesai'
        ]);

        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('magang/file', 'public');
        }

        $magang->update($data);

        // ✅ NOTIFIKASI
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Update Pengajuan Magang',
            'Data pengajuan magang kamu berhasil diperbarui',
            url('/notifikasi')
        ));

        return back()->with('success', 'Magang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $magang = Magang::where('magang_id', $id)->firstOrFail();

        // ✅ HANYA BOLEH HAPUS JIKA MASIH PROSES
        if ($magang->user_id != Auth::id() || $magang->status_pengajuan != 'proses') {
            return back();
        }

        $magang->delete();

        // ✅ NOTIFIKASI
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Pengajuan Magang Dihapus',
            'Pengajuan magang kamu berhasil dihapus',
            url('/notifikasi')
        ));

        return back()->with('success', 'Magang berhasil dihapus');
    }
}
