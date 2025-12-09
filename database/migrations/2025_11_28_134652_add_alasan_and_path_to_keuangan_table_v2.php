<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('keuangan', 'path_bukti_transfer')) {
                $table->string('path_bukti_transfer')->nullable()->after('keterangan');
            }
            if (!Schema::hasColumn('keuangan', 'alasan_ditangguhkan')) {
                $table->text('alasan_ditangguhkan')->nullable()->after('path_bukti_transfer');
            }
        });
    }

    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            // Hapus kolom saat rollback
            if (Schema::hasColumn('keuangan', 'path_bukti_transfer')) {
                $table->dropColumn('path_bukti_transfer');
            }
            if (Schema::hasColumn('keuangan', 'alasan_ditangguhkan')) {
                $table->dropColumn('alasan_ditangguhkan');
            }
        });
    }
};