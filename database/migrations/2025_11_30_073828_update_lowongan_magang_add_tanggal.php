<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {

            if (!Schema::hasColumn('lowongan_magang', 'tanggal_mulai')) {
                $table->date('tanggal_mulai')->nullable();
            }

            if (!Schema::hasColumn('lowongan_magang', 'tanggal_selesai')) {
                $table->date('tanggal_selesai')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
        });
    }
};
