<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenMahasiswa extends Model
{
    protected $table = 'dokumen_mahasiswa';

    protected $fillable = [
        'user_id',
        'jenis',
        'file_path',
    ];
}
