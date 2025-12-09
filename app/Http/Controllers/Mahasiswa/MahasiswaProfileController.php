<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;   // ← WAJIB!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa\Post;

class MahasiswaProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = Post::with('user', 'comments', 'likes')
            ->where('user_id', $user->id)
            ->orderBy('tanggal_post', 'desc')
            ->get();

        return view('mahasiswa.profil.index', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mahasiswa.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . ',id',
            'bio' => 'nullable|string|max:500',
            'foto_profile' => 'nullable|image|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->hasFile('foto_profile')) {

            if ($user->foto_profile && Storage::exists($user->foto_profile)) {
                Storage::delete($user->foto_profile);
            }

            $user->foto_profile = $request->file('foto_profile')->store('profiles', 'public');
        }

        $user->save();

        return redirect()->route('mahasiswa.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
