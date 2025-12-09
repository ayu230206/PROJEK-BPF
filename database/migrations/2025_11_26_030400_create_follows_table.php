<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id('follow_id');
            
            // Perbaikan FK: Merujuk ke kolom 'id' di tabel 'users' (standar Laravel)
            $table->foreignId('follower_id')->constrained('users', 'id')->onDelete('cascade');
            
            // Perbaikan FK: Merujuk ke kolom 'id' di tabel 'users' (standar Laravel)
            $table->foreignId('following_id')->constrained('users', 'id')->onDelete('cascade');
            
            // Menambahkan Unique Constraint agar satu user hanya bisa follow user lain sekali
            $table->unique(['follower_id', 'following_id']); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};