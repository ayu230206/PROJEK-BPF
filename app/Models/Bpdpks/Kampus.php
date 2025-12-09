<?php

namespace App\Models\Bpdpks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MahasiswaDetail;
class Kampus extends Model
{
    use HasFactory;

    protected $table = 'kampus'; 
    
    protected $fillable = [
        'nama_kampus',
        'kode_kampus',
        'alamat', 
        'nomor_mou', 
        'tanggal_mou', 
        // PERBAIKAN: Menggunakan kolom DB yang benar
        'status_kerjasama', 
        'kontak_person', 
        'path_mou_dokumen', 
    ];

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        // Sesuaikan Model MahasiswaDetail
        return $this->hasMany(\App\Models\MahasiswaDetail::class); 
    }

    /**
     * Accessor untuk mendapatkan status badge berdasarkan ENUM DB
     */
    public function getStatusBadge()
    {
        $statusDb = $this->status_kerjasama;
        
        switch ($statusDb) {
            case 'aktif':
                return '<span class="badge bg-success">Aktif</span>';
            case 'ditolak':
                return '<span class="badge bg-danger">Nonaktif</span>';
            case 'pending':
                return '<span class="badge bg-warning text-dark">Pending</span>';
            default:
                return '<span class="badge bg-secondary">Tidak Diketahui</span>';
        }
    }

public function mahasiswaDetails()
{
    // Relasi one-to-many ke detail mahasiswa
    return $this->hasMany(MahasiswaDetail::class, 'kampus_id');
}
}