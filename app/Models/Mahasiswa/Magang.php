<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magang';
    protected $primaryKey = 'magang_id';

    protected $fillable = [
        'user_id',
        'tempat_magang',
        'posisi',
        'deskripsi',
        'mulai',
        'selesai',
        'status_pengajuan',
        'tanggal_pengajuan',
        'file_pendukung'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
