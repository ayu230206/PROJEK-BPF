<?php

namespace App\Models\Bpdpks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// Import Model User (Asumsi User masih berada di App\Models)
use App\Models\User; 

class Keuangan extends Model
{
    use HasFactory;
    
    protected $table = 'keuangan';

    protected $fillable = [
        'mahasiswa_id', 
        'semester', 
        'tanggal_transfer', 
        'jumlah_bulanan', 
        'jumlah_buku', 
        'status_pencairan', 
        'keterangan',
        'path_bukti_transfer', // <-- DITAMBAHKAN
        'alasan_ditangguhkan'
    ];

    /**
     * Relasi ke Model User (Mahasiswa).
     * Kolom 'mahasiswa_id' merujuk ke 'id' di tabel 'users'.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id', 'id');
    }

    /**
     * Mengembalikan tag HTML Badge untuk status pencairan.
     */
    public function getStatusBadge()
    {
        $status = strtolower($this->status_pencairan);
        switch ($status) {
            case 'ditransfer':
            case 'diterima':
                return '<span class="badge badge-approved">'.ucfirst($status).'</span>';
            case 'proses':
                return '<span class="badge badge-pending">Proses</span>';
            case 'ditangguhkan':
                return '<span class="badge badge-rejected">Ditangguhkan</span>';
            default:
                return '<span class="badge badge-review">Review</span>';
        }
    }
    
    /**
     * Mengubah format jumlah_bulanan menjadi Rupiah
     */
    public function getJumlahBulananRupiahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_bulanan, 0, ',', '.');
    }

    /**
     * Mengubah format jumlah_buku menjadi Rupiah
     */
    public function getJumlahBukuRupiahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_buku, 0, ',', '.');
    }

    public static function getTotalPengeluaran()
    {
        return Keuangan::whereIn('status_pencairan', ['ditransfer', 'diterima'])
                       ->sum(DB::raw('jumlah_bulanan + jumlah_buku'));
    }
}