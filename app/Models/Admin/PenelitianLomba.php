<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenelitianLomba extends Model
{
    use HasFactory;

    protected $table = 'penelitian_lomba';

    protected $fillable = [
        'tipe',             // 'penelitian' atau 'lomba'
        'judul',
        'deskripsi',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_berakhir',
        'link_pendaftaran'  // Opsional, jika pendaftaran external
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}