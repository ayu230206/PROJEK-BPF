<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'like_id';
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
        'tanggal_like'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
