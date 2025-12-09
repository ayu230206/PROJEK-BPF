<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['mahasiswa', 'admin', 'bpdpks']);
            $table->unsignedBigInteger('asal_kampus')->nullable();
            $table->foreign('asal_kampus')->references('id')->on('kampus')->onDelete('set null');
            $table->string('angkatan')->nullable();
            $table->text('bio')->nullable();
            $table->string('foto_profile')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};