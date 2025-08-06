<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('kelas_genze', function (Blueprint $table) {
            $table->unsignedBigInteger('jadwal_kelas_id')->nullable()->after('link_zoom_default');

            $table->foreign('jadwal_kelas_id')
                  ->references('id_jadwalkelas')
                  ->on('jadwal_kelas')
                  ->onDelete('set null'); // jika jadwal dihapus, kolom ini menjadi null
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('kelas_genze', function (Blueprint $table) {
            $table->dropForeign(['jadwal_kelas_id']);
            $table->dropColumn('jadwal_kelas_id');
        });
    }
};
