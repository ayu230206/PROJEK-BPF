<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Bpdpks\KeuanganSeeder;
use Database\Seeders\AdminSeeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the application's database.
     */
    public function run(): void
    {
        // Seeder awal
        $this->call([
            DataKampusSeeder::class,
            UserRoleSeeder::class,
        ]);
        
        // Seeder data fiktif
        $this->call([
            KampusSeeder::class,
            MahasiswaSeeder::class,
            // KeuanganSeeder bisa ditambahkan jika dibutuhkan
            LowonganMagangSeeder::class,
        ]);
        
        $this->call([
            BankJudulProyekSeeder::class,
        ]);
        // User Admin BPDPKS aman dari duplikasi
        User::firstOrCreate(
            ['email' => 'bpdpks@admin.com'], // cek email dulu
            [
                'nama_lengkap' => 'BPDPKS User',
                'password' => Hash::make('password'),
                'role' => 'bpdpks',
                'status_aktif' => true,
            ]
        );
        
        $this->command->info('Database berhasil di-seed dengan data lengkap.');
    }
}
