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
        Schema::create('lowongan_aplikasi', function (Blueprint $table) {
            $table->id();
            // ID Lowongan/Magang yang dilamar
            $table->foreignId('lowongan_id')->constrained('magang_lowongan')->onDelete('cascade');
            // ID Mahasiswa yang melamar
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            // Status aplikasi: diajukan, diterima, ditolak
            $table->enum('status', ['diajukan', 'diterima', 'ditolak'])->default('diajukan');
            $table->text('catatan_admin')->nullable(); // Catatan dari admin saat menyetujui/menolak
            $table->timestamps();

            // Mencegah mahasiswa melamar lowongan yang sama lebih dari sekali
            $table->unique(['lowongan_id', 'mahasiswa_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_aplikasi');
    }
};