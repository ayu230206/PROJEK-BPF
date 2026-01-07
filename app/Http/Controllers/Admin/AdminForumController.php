<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Post; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminForumController extends Controller
{
    public function index()
    {
        // Menampilkan semua post forum untuk dimoderasi
        $posts = Post::with(['user', 'comments'])->latest()->paginate(10);
        return view('admin.forum.index', compact('posts'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($post->gambar && Storage::exists('public/' . $post->gambar)) {
            Storage::delete('public/' . $post->gambar);
        }
        
        $post->delete();

        return redirect()->back()->with('success', 'Postingan forum berhasil dihapus oleh Admin.');
    }
}