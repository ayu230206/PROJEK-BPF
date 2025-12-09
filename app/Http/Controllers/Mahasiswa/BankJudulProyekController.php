<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\BankJudulProyek;

class BankJudulProyekController extends Controller
{
    public function index()
    {
        $data = BankJudulProyek::latest()->get();

        return view('mahasiswa.proyek.bank-judul-proyek-akhir', compact('data'));
    }
}
