<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('judul'); // Banner/foto lowongan
            $table->string('file_pendukung')->nullable()->after('foto'); // File PDF persyaratan
        });
    }

    public function down(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
            $table->dropColumn(['foto', 'file_pendukung']);
        });
    }
};
