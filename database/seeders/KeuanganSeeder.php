<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bpdpks\Keuangan;
use App\Models\User; // Asumsi mahasiswa_id adalah foreign key ke users table

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID dari user dengan role 'mahasiswa'
        $mahasiswaIds = User::where('role', 'mahasiswa')->pluck('id');
        $statuses = ['ditransfer', 'proses', 'diterima', 'ditangguhkan'];

        if ($mahasiswaIds->isEmpty()) {
            $this->command->info('Tidak ada user dengan role mahasiswa. Lewati seeding Keuangan.');
            return;
        }

        foreach ($mahasiswaIds as $mahasiswaId) {
            // Buat 3 data Keuangan per mahasiswa
            for ($i = 1; $i <= 3; $i++) {
                Keuangan::create([
                    'mahasiswa_id' => $mahasiswaId,
                    'semester' => 'Semester ' . $i,
                    'tanggal_transfer' => now()->subMonths(rand(1, 12))->subDays(rand(1, 28)),
                    'jumlah_bulanan' => rand(1000000, 2500000),
                    'jumlah_buku' => rand(250000, 500000),
                    'status_pencairan' => $statuses[array_rand($statuses)],
                    'keterangan' => 'Pencairan dana beasiswa untuk semester ke-' . $i . '.',
                ]);
            }
        }

        $this->command->info('Data Keuangan berhasil ditambahkan.');
    }
}