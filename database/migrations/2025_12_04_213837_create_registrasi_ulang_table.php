<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrasi_ulang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('semester_ke')->nullable();
            
            // Kolom Syarat
            $table->boolean('sudah_feedback')->default(false); // Syarat 1: Sudah isi feedback
            $table->boolean('syarat_nilai_terpenuhi')->default(false); // Syarat 2: IPK/IPS > min
            
            // Kolom Status
            $table->enum('status_regis', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            
            $table->timestamps();
            $table->unique(['user_id', 'semester_ke']); // Hanya boleh satu registrasi per semester
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrasi_ulang');
    }
};