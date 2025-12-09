<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaDetail extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_detail';

    // Kolom fillable sesuai dengan migrasi mahasiswa_detail Anda
    protected $fillable = [
        'user_id','nama','nim', 'kampus_id', 'program_studi', 'lama_studi', 
        'telepon', 'alamat_domisili', 'path_ktp', 'path_kartu_mhs', 
        'path_transkrip_nilai', 'path_foto_formal', 'ipk', 'ips_terakhir'
    ];
    
    // Relasi ke User (1:1)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Kampus (N:1)
    public function kampus()
    {
        // Foreign key di tabel ini adalah 'kampus_id'
        // Karena Kampus berada di namespace App\Models\Bpdpks, kita harus impor atau menggunakan fully qualified name.
        // Asumsi Kampus berada di App\Models\Bpdpks\Kampus (sesuai rencana awal)
        return $this->belongsTo(\App\Models\Bpdpks\Kampus::class, 'kampus_id', 'id');
    }
    
    /**
     * Accessor untuk mendapatkan badge status IPK.
     * Gunakan warna yang sudah didefinisikan di CSS: primary, secondary, danger.
     */
    public function getIpkBadgeAttribute(): string
    {
        if ($this->ipk >= 3.80) {
            return '<span class="badge bg-primary">Excellent</span>';
        } elseif ($this->ipk >= 3.50) {
            return '<span class="badge bg-secondary">Good</span>';
        } else {
            return '<span class="badge bg-danger">Needs Attention</span>';
        }
    }
}