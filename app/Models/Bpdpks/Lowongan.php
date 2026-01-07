<?php

namespace App\Models\Bpdpks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Perlu di-import
use App\Models\Bpdpks\LowonganAplikasi; // Jika LowonganAplikasi juga di Bpdpks

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'magang_lowongan';

    protected $fillable = [
        'tipe',
        'judul',
        'deskripsi',
        'kualifikasi',
        'deadline',
        'diinput_oleh_id',


        // 🔥 KOLOM BARU DITAMBAHKAN UNTUK MASSA ASSIGNMENT
        'foto',
        'file_pendukung',
        'lokasi',
        'gaji',
        'tanggal_mulai',
        'tanggal_selesai',

        'file_path'

    ];

    /**
     * Relasi ke User (Admin/BPDPKS) yang menginput lowongan.
     */
    public function diinputOleh()
    {
        return $this->belongsTo(User::class, 'diinput_oleh_id');
    }

    /**
     * Relasi ke Aplikasi yang masuk untuk lowongan ini.
     */
    public function aplikasi()
    {
        return $this->hasMany(LowonganAplikasi::class, 'lowongan_id');
    }

    /**
     * Helper untuk menampilkan badge Tipe.
     */
    public function getTipeBadge()
    {
        if ($this->tipe == 'magang') {
            return '<span class="badge text-bg-info">Magang</span>';
        }
        return '<span class="badge text-bg-success">Lowongan Kerja</span>';
    }
}
