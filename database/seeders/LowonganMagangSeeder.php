<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lowongan_magang')->insert([
            [
                'judul' => 'Magang Web Developer',
                'deskripsi' => 'Membantu pengembangan website perusahaan, membuat fitur baru, dan memperbaiki bug.',
                'perusahaan' => 'PT Teknologi Nusantara',
                'lokasi' => 'Pekanbaru',
                'tanggal_mulai' => '2025-01-10',
                'tanggal_selesai' => '2025-04-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Magang Administrasi Perkantoran',
                'deskripsi' => 'Mengelola dokumen, surat masuk/keluar, dan mendukung operasional kantor.',
                'perusahaan' => 'CV Maju Bersama',
                'lokasi' => 'Jakarta',
                'tanggal_mulai' => '2025-02-01',
                'tanggal_selesai' => '2025-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Magang Graphic Designer',
                'deskripsi' => 'Membuat konten sosial media, poster, banner, dan materi desain lainnya.',
                'perusahaan' => 'Creative Studio ID',
                'lokasi' => 'Bandung',
                'tanggal_mulai' => '2025-03-01',
                'tanggal_selesai' => '2025-06-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
