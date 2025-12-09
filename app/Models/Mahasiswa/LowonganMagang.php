<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagang extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'lowongan_magang';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'judul',
        'deskripsi',
        'perusahaan',
        'lokasi',
        'deadline',
    ];

    // Cast kolom tertentu
    protected $casts = [
        'deadline' => 'date',
    ];
}
