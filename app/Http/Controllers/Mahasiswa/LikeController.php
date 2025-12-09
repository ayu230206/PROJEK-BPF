<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Like;
use App\Models\Mahasiswa\Post;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
    /**
     * LIKE / UNLIKE (AJAX)
     */
    public function toggle($post_id)
    {
        $user = Auth::user();

        // Ambil post (404 jika tidak ada)
        $post = Post::findOrFail($post_id);

        // Cek apakah user sudah like
        $existing = Like::where('post_id', $post_id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($existing) {
            // UNLIKE
            $existing->delete();

            $count = Like::where('post_id', $post_id)->count();

            return response()->json([
                'liked' => false,
                'likes_count' => $count,
            ]);
        }

        // LIKE
        Like::create([
            'post_id' => $post_id,
            'user_id' => $user->id,
        ]);

        // Kirim notifikasi ke pemilik post (kecuali like sendiri)
        if ($post->user_id != $user->id) {
            $post->user->notify(new LikeNotification($post, $user));
        }

        $count = Like::where('post_id', $post_id)->count();

        return response()->json([
            'liked' => true,
            'likes_count' => $count,
        ]);
    }
}
