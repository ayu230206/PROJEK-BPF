<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'cv',
        'portofolio',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Relasi ke LowonganKerja
    public function lowongan()
    {
        return $this->belongsTo(LowonganKerja::class, 'lowongan_id', 'lowongan_id');
    }
}
