<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel likes forum
        Schema::create('likes', function (Blueprint $table) {
            $table->id('like_id');
            $table->foreignId('post_id')->constrained('posts', 'post_id')->onDelete('cascade');
            
            // Perbaikan FK ke users: merujuk ke 'id' standar Laravel
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade'); 
            
            // Penambahan: Mencegah satu user LIKE post yang sama berkali-kali
            $table->unique(['user_id', 'post_id']); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};