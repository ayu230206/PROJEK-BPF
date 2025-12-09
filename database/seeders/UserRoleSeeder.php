<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kampus;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@bpdpks.id'],  // cek email
            [
                'nama_lengkap' => 'Super Admin Beasiswa',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status_aktif' => true,
            ]
        );

        // 2. Akun BPDPKS
        User::firstOrCreate(
            ['email' => 'naldi@bpdpks.id'],
            [
                'nama_lengkap' => 'Naldi BPDPKS',
                'password' => Hash::make('password'),
                'role' => 'bpdpks',
                'status_aktif' => true,
            ]
        );

        // 3. Akun Mahasiswa
        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@kampus.ac.id'],
            [
                'nama_lengkap' => 'Fulan Mahasiswa',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'asal_kampus' => Kampus::first()->id ?? null,
                'angkatan' => '2023',
                'bio' => null,
                'foto_profile' => null,
                'status_aktif' => true,
            ]
        );

        // Detail mahasiswa (hanya dibuat jika belum ada)
        DB::table('mahasiswa_detail')->updateOrInsert(
            ['user_id' => $mahasiswa->id], // cek berdasarkan user_id
            [
                'nim' => '20230001',
                'kampus_id' => Kampus::first()->id ?? null,
                'program_studi' => 'Teknologi Hasil Perkebunan',
                'lama_studi' => 3,
                'telepon' => '081234567890',
                'alamat_domisili' => 'Jl. Kebun Sawit No. 10',
                'ipk' => 3.75,
                'ips_terakhir' => 3.80,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
