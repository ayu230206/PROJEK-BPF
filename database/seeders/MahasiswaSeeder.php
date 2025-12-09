<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel kampus sudah terisi
        $kampusIds = DB::table('kampus')->pluck('id')->toArray();
        if (empty($kampusIds)) {
            $this->command->info('Kampus belum di-seed. Lewati MahasiswaSeeder.');
            return;
        }
        
        $prodi = ['Teknik Informatika', 'Desain Komunikasi Visual', 'Manajemen Bisnis', 'Akuntansi', 'Ilmu Hukum'];
        // Menggunakan NIM yang lebih sederhana agar tidak terlalu panjang
        $nimPrefix = 202201;

        for ($i = 1; $i <= 10; $i++) {
            // Menggunakan nama yang lebih terstruktur (bukan random string) untuk kemudahan debugging
            $nama = 'Mahasiswa Beasiswa ' . $i; 
            $kampusId = $kampusIds[array_rand($kampusIds)];
            $nim = $nimPrefix . str_pad($i, 4, '0', STR_PAD_LEFT);

            // 1. Insert ke tabel users (role 'mahasiswa')
         // 1. Insert ke tabel users (role 'mahasiswa')
$userId = DB::table('users')->insertGetId([
    'nama_lengkap' => $nama,
    'email' => 'mhs' . $i . '@test.com',
    'password' => Hash::make('password'),
    'role' => 'mahasiswa',
    'asal_kampus' => $kampusId,
    'angkatan' => '2022',
    'status_aktif' => true,
    'created_at' => now(),
    'updated_at' => now(),
]);

            // 2. Insert ke tabel mahasiswa_detail
            DB::table('mahasiswa_detail')->insert([
                'user_id' => $userId,
                'nim' => $nim,
                'kampus_id' => $kampusId,
                'program_studi' => $prodi[array_rand($prodi)],
                'lama_studi' => 8, 
                'telepon' => '081' . rand(100000000, 999999999),
                'alamat_domisili' => 'Jl. Beasiswa Sawit No. ' . $i . ', Kota Dumy',
                'ipk' => round(mt_rand(300, 400) / 100, 2),
                'ips_terakhir' => round(mt_rand(300, 400) / 100, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}