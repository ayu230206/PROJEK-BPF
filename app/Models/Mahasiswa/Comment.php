<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';
    
    protected $fillable = [
        'post_id',
        'user_id',
        'komentar',
        'tanggal_comment',
    ];

    protected $casts = [
        'tanggal_comment' => 'datetime', // ← tambahkan ini
    ];

    public function user()
    { 
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    public function post()
    { 
        return $this->belongsTo(Post::class, 'post_id', 'post_id'); 
    }
}
