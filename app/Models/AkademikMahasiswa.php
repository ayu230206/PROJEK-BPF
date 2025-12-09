<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkademikMahasiswa extends Model
{
    protected $table = 'akademik_mahasiswa';

    protected $fillable = [
        'user_id',
        'ipk',
        'ips',
    ];

    protected $casts = [
        'ips' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
