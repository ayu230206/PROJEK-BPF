<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kampus', function (Blueprint $table) {
            // Tambahkan kolom yang hilang
            $table->string('kode_kampus')->nullable()->after('nama_kampus');
            $table->string('nomor_mou')->nullable()->after('alamat');
            $table->date('tanggal_mou')->nullable()->after('nomor_mou');

            // Hapus kolom status lama dan ganti dengan yang Anda inginkan jika perlu
            // ATAU, biarkan status_kerjasama dan ubah logic di controller (Lihat Solusi 2b)
            
            // JIKA ANDA INGIN MENGGUNAKAN status_aktif (0/1) dan menghapus status_kerjasama (enum):
            // $table->dropColumn('status_kerjasama');
            // $table->boolean('status_aktif')->default(false)->after('path_mou_dokumen');
        });
    }

    public function down(): void
    {
        Schema::table('kampus', function (Blueprint $table) {
            $table->dropColumn(['kode_kampus', 'nomor_mou', 'tanggal_mou']);
            
            // JIKA ANDA MENGHAPUSNYA DI ATAS:
            // $table->dropColumn('status_aktif');
            // $table->enum('status_kerjasama', ['aktif', 'pending', 'ditolak'])->default('pending');
        });
    }
};