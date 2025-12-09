<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LowonganKerjaSeeder extends Seeder
{
    public function run()
    {
        DB::table('lowongan_kerja')->insert([
            [
                'judul' => 'Frontend Developer',
                'perusahaan' => 'PT Teknologi Indonesia',
                'deskripsi' => 'Kami mencari Frontend Developer berpengalaman dengan React/Vue.',
                'lokasi' => 'Jakarta',
                'gaji' => 'Rp 7.000.000 – Rp 10.000.000',
                'tanggal_post' => Carbon::now()->format('Y-m-d'),
                'status' => 'buka',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Backend Developer',
                'perusahaan' => 'PT Solusi Digital',
                'deskripsi' => 'Backend Developer yang menguasai Laravel & MySQL.',
                'lokasi' => 'Bandung',
                'gaji' => 'Rp 8.000.000 – Rp 12.000.000',
                'tanggal_post' => Carbon::now()->format('Y-m-d'),
                'status' => 'buka',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
