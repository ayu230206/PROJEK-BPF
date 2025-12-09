<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_pengirim')->nullable(); // Admin yang buat
            $table->string('judul');
            $table->text('isi_pesan');
            $table->string('jenis')->default('umum'); // umum, penting, dll
            $table->string('role_penerima')->default('mahasiswa'); // Siapa yang bisa lihat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};