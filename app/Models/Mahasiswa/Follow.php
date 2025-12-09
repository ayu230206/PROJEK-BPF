<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'follow_id';
    
    protected $fillable = [
        'follower_id',
        'following_id',
    ];
    
    public function follower()
    { 
        return $this->belongsTo(\App\Models\User::class, 'follower_id', 'id'); 
    }
    
    public function following()
    { 
        return $this->belongsTo(\App\Models\User::class, 'following_id', 'id'); 
    }
}