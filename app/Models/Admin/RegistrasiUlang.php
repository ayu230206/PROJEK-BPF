<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiUlang extends Model
{
    use HasFactory;

    protected $table = 'registrasi_ulang';

    protected $fillable = [
        'user_id', 
        'semester_ke', 
        'sudah_feedback', // Cek apakah sudah mengisi feedback
        'syarat_nilai_terpenuhi', // Cek apakah IPK/IPS memenuhi syarat
        'status_regis', // pending, disetujui, ditolak
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}