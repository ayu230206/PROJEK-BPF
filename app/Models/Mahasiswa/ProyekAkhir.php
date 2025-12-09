<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekAkhir extends Model
{
    use HasFactory;
    
    // Pastikan properti ini ada
    protected $table = 'proyek_akhir'; 

    protected $primaryKey = 'proyek_id';
    
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'pembimbing',
        'status_proyek',
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function user()
    { 
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id'); 
    }
}