<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
            // Kolom 'foto' dan 'file_pendukung' sudah ada di tabel, 
            // sehingga baris penambahan kolom di 'up()' ini dikosongkan 
            // untuk menghindari error 'Duplicate column name'.
            // KODE BARIS DI SINI SUDAH DIHAPUS.
        });
    }

    public function down(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
            // Karena tidak ada kolom yang ditambahkan di 'up()', 
            // 'down()' juga dikosongkan agar rollback aman.
        });
    }
};