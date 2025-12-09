<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi plural Laravel
    protected $table = 'lowongan_kerja';

    // Primary key jika bukan 'id'
    protected $primaryKey = 'lowongan_id';

    // Field yang bisa diisi massal
    protected $fillable = [
        'judul',
        'perusahaan',
        'deskripsi',
        'lokasi',
        'gaji',
        'tanggal_post',
        'status',
    ];
}
