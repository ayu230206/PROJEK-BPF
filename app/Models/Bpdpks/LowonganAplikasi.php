<?php

namespace App\Models\Bpdpks; // <-- UBAH INI

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Perlu di-import
use App\Models\Bpdpks\Lowongan; // Jika Lowongan juga di Bpdpks

class LowonganAplikasi extends Model
{
    use HasFactory;

    protected $table = 'lowongan_aplikasi';

    protected $fillable = [
        'lowongan_id',
        'mahasiswa_id',
        'cv',
        'portofolio',
        'status',
        'catatan_admin'
    ];

    /**
     * Relasi ke Lowongan yang dilamar.
     */
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    /**
     * Relasi ke Mahasiswa yang melamar.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Helper untuk menampilkan badge Status.
     */
    public function getStatusBadge()
    {
        switch ($this->status) {
            case 'diterima':
                return '<span class="badge text-bg-success">Diterima</span>';
            case 'ditolak':
                return '<span class="badge text-bg-danger">Ditolak</span>';
            default: // diajukan
                return '<span class="badge text-bg-warning">Diajukan</span>';
        }
    }
}
