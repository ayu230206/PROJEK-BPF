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
        // Tabel Magang dan Lowongan Kerja
        Schema::create('magang_lowongan', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['magang', 'lowongan_kerja']);
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->text('kualifikasi')->nullable();
            $table->date('deadline')->nullable();
            // Log siapa (Admin/BPDPKS) yang input
            $table->foreignId('diinput_oleh_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });

        // Tabel Penelitian dan Lomba
        Schema::create('penelitian_lomba', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['penelitian', 'lomba']);
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang_lowongan');
        Schema::dropIfExists('penelitian_lomba');
    }
};