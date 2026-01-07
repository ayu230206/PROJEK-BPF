<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bpdpks\Feedback;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        // Ambil semua feedback, dengan relasi mahasiswa, dan pagination
        $feedbacks = Feedback::with('mahasiswa')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('bpdpks.feedback.index', compact('feedbacks'));
    }

    /**
     * Menampilkan detail feedback tertentu.
     */
    public function show($id)
    {
        $feedback = Feedback::with('mahasiswa')->findOrFail($id);
        return view('bpdpks.feedback.show', compact('feedback'));
    }
}
