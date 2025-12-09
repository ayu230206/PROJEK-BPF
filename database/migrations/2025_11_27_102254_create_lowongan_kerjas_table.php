<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lowongan_kerja', function (Blueprint $table) {
            $table->id('lowongan_id');
            $table->string('judul');
            $table->string('perusahaan');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->string('gaji')->nullable(); // <- kolom gaji ditambahkan
            $table->date('tanggal_post');
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_kerja');
    }
};
