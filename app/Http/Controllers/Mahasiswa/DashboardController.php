<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Mengambil data postingan forum terbaru
        $posts = Post::with('user', 'comments', 'likes')
                      ->orderBy('tanggal_post', 'desc')
                      ->get();

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'posts' => $posts // Saya tambahkan ini agar data posts bisa dipakai di view
        ]);
    }
}