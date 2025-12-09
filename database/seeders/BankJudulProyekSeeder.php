<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa\BankJudulProyek;

class BankJudulProyekSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Sistem Informasi Beasiswa Berbasis Web',
                'bidang' => 'Web Development',
                'deskripsi' => 'Aplikasi pengelolaan beasiswa dan pendaftaran online mahasiswa.'
            ],
            [
                'judul' => 'Aplikasi Monitoring Magang Mahasiswa',
                'bidang' => 'Mobile Application',
                'deskripsi' => 'Aplikasi mobile untuk monitoring kegiatan magang mahasiswa.'
            ],
            [
                'judul' => 'Sistem Rekomendasi Judul Proyek Akhir',
                'bidang' => 'Artificial Intelligence',
                'deskripsi' => 'Sistem yang merekomendasikan judul proyek akhir berdasarkan minat.'
            ],
            [
                'judul' => 'Dashboard Akademik Mahasiswa',
                'bidang' => 'Web Development',
                'deskripsi' => 'Dashboard akademik berisi IPK, dokumen, dan prestasi.'
            ],
            [
                'judul' => 'Sistem Informasi Lowongan Magang dan Kerja',
                'bidang' => 'Web Development',
                'deskripsi' => 'Sistem terintegrasi untuk informasi lowongan magang dan kerja.'
            ],
        ];

        foreach ($data as $item) {
            BankJudulProyek::create($item);
        }
    }
}
