<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    use HasFactory;

    // Nama tabel sesuai definisi sebelumnya
    protected $table = 'kampus';

    // Menentukan custom primary key
    protected $primaryKey = 'kampus_id';

    // Mematikan timestamps (created_at & updated_at)
    public $timestamps = false;

    // Field fillable, menggabungkan dan menjaga field yang sudah ada
    protected $fillable = [
        'nama_kampus',
        'alamat',
        'kontak_person',
        'status_kerjasama',
        'path_mou_dokumen',
        // 'kode_kampus' tidak dimasukkan jika tidak ada di DB, 
        // tetapi relasi tetap ditambahkan:
    ];
    
    // --- RELASI DITAMBAHKAN ---

    /**
     * Relasi ke MahasiswaDetail (1-to-many).
     * Foreign key: kampus_id di tabel 'mahasiswa_detail'
     */
    public function mahasiswadetail()
    {
        // Menggunakan primary key yang benar ('kampus_id')
        return $this->hasMany(MahasiswaDetail::class, 'kampus_id', 'kampus_id');
    }

    /**
     * Relasi ke User (jika User menggunakan 'asal_kampus' sebagai foreign key ke tabel ini)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'asal_kampus', 'kampus_id');
    }
}