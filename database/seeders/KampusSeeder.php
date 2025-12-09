<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kampus')->insert([
            [
                'nama_kampus' => 'Universitas Teknologi Digital',
                'alamat' => 'Jl. Digital No. 1, Bandung',
                'kontak_person' => 'Bambang Sudiro',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Institut Seni Rupa Nusantara',
                'alamat' => 'Jl. Budaya No. 45, Yogyakarta',
                'kontak_person' => 'Dewi Sartika',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Politeknik Energi Terbarukan',
                'alamat' => 'Jl. Hijau No. 10, Surabaya',
                'kontak_person' => 'Cipto Nugroho',
                'status_kerjasama' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Sekolah Tinggi Ilmu Kesehatan',
                'alamat' => 'Jl. Medika No. 22, Jakarta',
                'kontak_person' => 'Siska Amelia',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Akademi Pariwisata Internasional',
                'alamat' => 'Jl. Wisata No. 5, Bali',
                'kontak_person' => 'Risa Handayani',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}