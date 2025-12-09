<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Admin\PenelitianLomba;
use Illuminate\Http\Request;

class InfoLombaController extends Controller
{
    public function index(Request $request)
    {
        $query = PenelitianLomba::where('tipe', 'lomba');

        // 🔍 Kalau ada input pencarian
        if ($request->q) {
            $query->where(function ($sub) use ($request) {
                $sub->where('judul', 'like', '%' . $request->q . '%')
                    ->orWhere('penyelenggara', 'like', '%' . $request->q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        $lombas = $query->latest()->get();

        return view('mahasiswa.info-lomba.index', compact('lombas'));
    }
}
