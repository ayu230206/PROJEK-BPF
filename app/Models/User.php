<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Models
use App\Models\Bpdpks\Kampus;
use App\Models\Bpdpks\Keuangan;
use App\Models\Mahasiswa\Post;
use App\Models\Mahasiswa\Comment;
use App\Models\Mahasiswa\Like;
use App\Models\Magang;
use App\Models\MahasiswaDetail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'google_id',
        'role',          // admin, bpdpks, mahasiswa
        'asal_kampus',   // ID Kampus
        'angkatan',
        'bio',
        'foto_profile',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi Akademik & Data Diri
     */
    public function detail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'user_id', 'id');
    }

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'asal_kampus', 'id');
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'mahasiswa_id', 'id');
    }

    /**
     * Relasi Forum Mahasiswa
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    /**
     * Relasi Magang
     */
    public function magangs()
    {
        return $this->hasMany(Magang::class, 'mahasiswa_id');
    }
}
