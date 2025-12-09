<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel forum post mahasiswa
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id'); // Primary key untuk post
            
            // Kolom Foreign Key yang benar-benar baru
            $table->foreignId('user_id') // Kolom bernama user_id
                  ->constrained('users') // Merujuk ke tabel 'users'
                  ->onDelete('cascade'); // Secara otomatis merujuk ke 'id' di tabel 'users'
                  
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->timestamp('tanggal_post')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};