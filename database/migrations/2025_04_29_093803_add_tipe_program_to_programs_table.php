<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('tipe_program')->after('nama_program');
            // Contoh isi: "Online", "Offline", "Hybrid"
        });
    }

    /**
     * Kembalikan migrasi.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('tipe_program');
        });
    }
};
