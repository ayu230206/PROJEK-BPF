<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Admin\PenelitianLomba;
use Illuminate\Http\Request;

class PenelitianController extends Controller
{
    public function index(Request $request)
    {
        $query = PenelitianLomba::where('tipe', 'penelitian');

        // Fitur pencarian
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penyelenggara', 'like', "%{$search}%");
            });
        }

        $penelitian = $query->latest()->paginate(10);

        // Supaya query string pencarian tetap ada di pagination
        $penelitian->appends($request->only('q'));

        return view('mahasiswa.penelitian.index', compact('penelitian'));
    }
}
