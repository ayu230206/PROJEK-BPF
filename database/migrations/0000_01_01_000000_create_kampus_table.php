<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kampus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampus')->unique();
            $table->text('alamat')->nullable();
            $table->string('kontak_person')->nullable();
            $table->enum('status_kerjasama', ['aktif', 'pending', 'ditolak'])->default('pending');
            $table->string('path_mou_dokumen')->nullable();
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kampus');
    }
};