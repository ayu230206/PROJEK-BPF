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
     * Menggunakan class Bootstrap standar (bg-...) untuk menjamin warna dan kontras.
     */
    public function getStatusBadge()
    {
        $status = strtolower($this->status_pencairan);
        switch ($status) {
            case 'ditransfer':
                // Sukses (Hijau)
                return '<span class="badge bg-success text-white">Ditransfer</span>';
            case 'diterima':
                // Selesai (Hijau/Biru Tua) - Menggunakan bg-primary sebagai alternatif yang kuat
                return '<span class="badge bg-primary text-white">Diterima</span>';
            case 'proses':
                // Proses (Biru terang/Cyan)
                return '<span class="badge bg-info text-dark">Proses</span>';
            case 'ditangguhkan':
                // Ditangguhkan (Kuning/Warning), Teks Gelap
                return '<span class="badge bg-warning text-dark">Ditangguhkan</span>';
            default:
                // Status lain/Review (Abu-abu)
                return '<span class="badge bg-secondary text-white">Review</span>';
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
