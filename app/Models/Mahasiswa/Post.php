<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa\Comment;
use App\Models\Mahasiswa\Like;
use App\Models\Mahasiswa\Share;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'user_id',
        'isi',
        'gambar',
        'tanggal_post',
    ];

    protected $casts = [
        'tanggal_post' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }

    public function shares()
    {
        return $this->hasMany(Share::class, 'post_id', 'post_id');
    }
    public function getRouteKeyName()
    {
        return 'post_id';
    }
}
