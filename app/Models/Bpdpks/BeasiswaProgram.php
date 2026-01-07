<?php

namespace App\Models\Bpdpks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Menggunakan Model User dari root Models

class BeasiswaProgram extends Model
{
    use HasFactory;

    protected $table = 'beasiswa_program';

    protected $fillable = [
        'judul',
        'isi_informasi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'path_banner_poster',
        'path_dokumen_panduan',
        'kontak_person_bpdpks',
        'created_by_user_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}
