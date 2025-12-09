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
        // Tabel Beasiswa Program (Informasi Program dan Jadwal)
        Schema::create('beasiswa_program', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi_informasi');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();

            // Kolom untuk file/gambar visual program
            $table->string('path_banner_poster')->nullable();
            $table->string('path_dokumen_panduan')->nullable();

            $table->string('kontak_person_bpdpks')->nullable();
            // Log siapa Admin yang input
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabel Feedback (Kritik dan Saran Mahasiswa)
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke users
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            
            $table->unsignedSmallInteger('semester_ke');
            $table->text('isi_feedback');
            $table->date('tanggal_input')->nullable();

            // Memastikan setiap mahasiswa hanya bisa input 1 kali per semester
            $table->unique(['mahasiswa_id', 'semester_ke']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa_program');
        Schema::dropIfExists('feedback');
    }
};