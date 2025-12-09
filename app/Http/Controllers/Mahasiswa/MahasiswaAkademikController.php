<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\MahasiswaDetail;
use App\Http\Controllers\Controller;
use App\Models\AkademikMahasiswa;
use App\Models\DokumenMahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa;


class MahasiswaAkademikController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $akademik = AkademikMahasiswa::where('user_id', $user->id)->first();
        $dokumen = DokumenMahasiswa::where('user_id', $user->id)->get();

        return view('mahasiswa.akademik.dashboard', compact('user', 'akademik', 'dokumen'));
    }

    public function uploadDokumen(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png'
        ]);

        $filePath = $request->file('dokumen')->store('dokumen', 'public');

        DokumenMahasiswa::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'file_path' => $filePath
        ]);

        return back()->with('success', 'Dokumen berhasil diupload!');
    }

    public function destroyDokumen($dokumen_id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($dokumen_id);
        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus!');
    }
    public function uploadPage()
    {
        $user = Auth::user();
        $dokumen = DokumenMahasiswa::where('user_id', $user->id)->get(); // ambil dokumen mahasiswa ini

        return view('mahasiswa.akademik.upload', compact('dokumen'));
    }
    public function ipk()
    {
        $mahasiswa = MahasiswaDetail::with(['user', 'kampus'])
            ->where('user_id', Auth::id())
            ->first(); // ubah firstOrFail() jadi first()

        return view('mahasiswa.akademik.ipk', compact('mahasiswa'));
    }
}
