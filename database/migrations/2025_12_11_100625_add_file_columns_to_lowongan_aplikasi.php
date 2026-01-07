<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lowongan_aplikasi', function (Blueprint $table) {
            if (!Schema::hasColumn('lowongan_aplikasi', 'cv')) {
                $table->string('cv')->nullable();
            }
            if (!Schema::hasColumn('lowongan_aplikasi', 'portofolio')) {
                $table->string('portofolio')->nullable();
            }
        });
    }


    public function down(): void
    {
        Schema::table('lowongan_aplikasi', function (Blueprint $table) {
            $table->dropColumn(['cv', 'portofolio']);
        });
    }
};
