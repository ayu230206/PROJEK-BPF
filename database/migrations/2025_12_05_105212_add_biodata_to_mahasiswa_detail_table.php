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
        Schema::table('mahasiswa_detail', function (Blueprint $table) {
        // Menambah kolom biodata jika belum ada
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->integer('umur')->nullable(); // Opsional (sebaiknya hitung dari tgl lahir, tapi kita buat kolomnya sesuai request)
        $table->string('status_ipk')->nullable(); // Baik, Buruk, Perlu Bimbingan
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa_detail', function (Blueprint $table) {
        $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'umur', 'status_ipk']);
    });
    }
};
