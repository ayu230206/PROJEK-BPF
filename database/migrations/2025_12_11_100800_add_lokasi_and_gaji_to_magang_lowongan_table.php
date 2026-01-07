<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('magang_lowongan', function (Blueprint $table) {
            // Tambahkan kolom lokasi (string)
            $table->string('lokasi')->nullable()->after('deadline'); 
            
            // Tambahkan kolom gaji (string, karena data gaji biasanya berbentuk teks seperti "Rp 5.000.000")
            $table->string('gaji')->nullable()->after('lokasi'); 

            // Jika Anda juga ingin menyimpan tanggal mulai dan selesai magang
            $table->date('tanggal_mulai')->nullable()->after('gaji');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
            // Hapus kolom saat rollback
            $table->dropColumn(['lokasi', 'gaji', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};

