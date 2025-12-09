<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel proyek akhir mahasiswa
        Schema::create('proyek_akhir', function (Blueprint $table) {
            $table->id('proyek_id');

            // PERBAIKAN 1: Merujuk ke kolom 'id' di tabel 'users'
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi')->nullable();

            // PERBAIKAN 2: Tambahkan kolom tanggal yang dibutuhkan oleh Controller
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->string('pembimbing')->nullable();
            $table->enum('status_proyek', ['pending', 'on_progress', 'completed'])
                ->default('pending');

            $table->year('tahun')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyek_akhir');
    }
};
