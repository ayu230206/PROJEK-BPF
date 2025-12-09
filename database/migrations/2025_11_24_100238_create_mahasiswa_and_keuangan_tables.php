<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nim', 50)->unique();
            $table->foreignId('kampus_id')->constrained('kampus')->onDelete('restrict');
            $table->string('program_studi');
            $table->unsignedSmallInteger('lama_studi')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('path_ktp')->nullable();
            $table->string('path_kartu_mhs')->nullable();
            $table->string('path_transkrip_nilai')->nullable();
            $table->string('path_foto_formal')->nullable();
            $table->decimal('ipk', 4, 2)->nullable();
            $table->decimal('ips_terakhir', 3, 2)->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('restrict');
            $table->string('semester', 50);
            $table->date('tanggal_transfer')->nullable();
            $table->decimal('jumlah_bulanan', 15, 2)->default(0.00);
            $table->decimal('jumlah_buku', 15, 2)->default(0.00);
            $table->enum('status_pencairan', ['proses', 'ditransfer', 'diterima', 'ditangguhkan'])->default('proses');
            $table->text('keterangan')->nullable();
            
            // Kolom baru untuk Bukti Transfer
            $table->string('path_bukti_transfer')->nullable(); 
            
            // Kolom baru untuk Alasan Ditangguhkan
            $table->text('alasan_ditangguhkan')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_detail');
        Schema::dropIfExists('keuangan');
    }
};