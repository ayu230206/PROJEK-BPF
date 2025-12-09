<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bpdpks\Feedback; // Pastikan path model ini benar
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    /**
     * Menampilkan formulir feedback dan riwayat feedback mahasiswa.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil riwayat feedback yang sudah pernah dikirim
        $riwayatFeedback = Feedback::where('mahasiswa_id', $user->id)
                                    ->orderBy('semester_ke', 'desc')
                                    ->get();

        // 2. Tentukan semester yang saat ini harus diisi (Misal: semester terakhir + 1)
        $semesterTerakhirDiisi = $riwayatFeedback->max('semester_ke') ?? 0;
        $semesterSaatIni = $semesterTerakhirDiisi + 1; 

        // 3. Cek apakah feedback untuk semester TARGET (semesterSaatIni) sudah ada (untuk PREFILL)
        $feedbackSaatIni = Feedback::where('mahasiswa_id', $user->id)
                                 ->where('semester_ke', $semesterSaatIni)
                                 ->first();

        // 4. Tentukan apakah sudah mengisi (digunakan untuk menampilkan pesan "Anda dapat mengedit")
        $sudahMengisi = $feedbackSaatIni !== null;
        
        // KIRIM variabel $feedbackSaatIni ke Blade
        return view('mahasiswa.feedback.index', compact('riwayatFeedback', 'semesterSaatIni', 'sudahMengisi', 'feedbackSaatIni'));
    }

    /**
     * Menyimpan atau Memperbarui feedback.
     */
    public function store(Request $request)
    {
        $mahasiswaId = Auth::id();
        $semesterKe = $request->semester_ke;

        $request->validate([
            // Tidak perlu lagi Rule::unique() karena kita mengizinkan UPDATE
            'semester_ke' => ['required', 'integer', 'min:1'],
            'isi_feedback' => 'required|string|min:10',
        ], [
            'isi_feedback.required' => 'Kolom Isi Feedback wajib diisi.',
            'isi_feedback.min' => 'Isi Feedback minimal :min karakter.',
        ]);
        
        // --- LOGIKA UPDATE OR CREATE (UPSERT) ---
        
        // 1. Cek apakah feedback untuk semester ini sudah ada
        $feedbackLama = Feedback::where('mahasiswa_id', $mahasiswaId)
                                ->where('semester_ke', $semesterKe)
                                ->first();

        if ($feedbackLama) {
            // 2. Jika sudah ada, lakukan UPDATE
            $feedbackLama->update([
                'isi_feedback' => $request->isi_feedback,
                'tanggal_input' => now(),
            ]);
            $pesan = 'Feedback Semester ' . $semesterKe . ' berhasil **diperbarui**!';
        } else {
            // 3. Jika belum ada, lakukan INSERT baru
            Feedback::create([
                'mahasiswa_id' => $mahasiswaId,
                'semester_ke' => $semesterKe,
                'isi_feedback' => $request->isi_feedback,
                'tanggal_input' => now(),
            ]);
            $pesan = 'Feedback Semester ' . $semesterKe . ' berhasil **dikirim**!';
        }

        return redirect()->route('mahasiswa.feedback.index')->with('success', $pesan);
    }
}