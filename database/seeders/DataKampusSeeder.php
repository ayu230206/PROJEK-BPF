<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKampusSeeder extends Seeder
{
    public function run(): void
    {
        // MATIKAN FK HANYA JIKA BUKAN SQLITE
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } else {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        // kosongkan tabel
        DB::table('kampus')->delete();

        // HIDUPKAN FK
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        DB::table('kampus')->insert([
            [
                'nama_kampus' => 'Institut Teknologi Sawit Indonesia (ITSI)',
                'alamat' => 'Medan, Sumatera Utara',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Politeknik Kelapa Sawit Citra Widya Edukasi (CWE)',
                'alamat' => 'Bekasi, Jawa Barat',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Politeknik Caltex Riau (PCR)',
                'alamat' => 'Jl. Umbansari No.1 Rumbai, Pekanbaru',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
