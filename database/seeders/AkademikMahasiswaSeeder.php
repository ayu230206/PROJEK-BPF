<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkademikMahasiswa;

class AkademikMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        AkademikMahasiswa::create([
            'user_id' => 1, // ID mahasiswa contoh
            'semester' => 4,
            'ips' => json_encode([
                1 => 3.12,
                2 => 3.45,
                3 => 3.55,
                4 => 3.80,
            ]),
            'ipk' => 3.48,
        ]);
    }
}
