<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'notifikasis'; // Pastikan nama tabel sesuai migrasi

    protected $fillable = [
        'user_id_pengirim', // Admin/System ID
        'judul',
        'isi_pesan',
        'jenis',            // umum, pencairan, registrasi_ulang
        'role_penerima',    // mahasiswa, dll (untuk broadcast)
        'is_read'           // boolean (jika notif personal)
    ];
}