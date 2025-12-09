<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankJudulProyek extends Model
{
    use HasFactory;

    protected $table = 'bank_judul_proyek';

    protected $fillable = [
        'judul',
        'bidang',
        'deskripsi',
    ];
}
