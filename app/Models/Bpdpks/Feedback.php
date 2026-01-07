<?php

namespace App\Models\Bpdpks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Menggunakan Model User dari root Models

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'mahasiswa_id',
        'semester_ke',
        'isi_feedback',
        'tanggal_input',
    ];

    /**
     * Relasi ke Mahasiswa (User) yang memberikan feedback.
     * Harus mengimpor App\Models\User.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    protected $casts = [
        'tanggal_input' => 'date',
    ];
}
