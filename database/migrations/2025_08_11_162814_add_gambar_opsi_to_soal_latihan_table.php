<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('soal_latihans', function (Blueprint $table) {
        $table->string('gambar_pilihan_a')->nullable();
        $table->string('gambar_pilihan_b')->nullable();
        $table->string('gambar_pilihan_c')->nullable();
        $table->string('gambar_pilihan_d')->nullable();
    });
}

public function down()
{
    Schema::table('soal_latihans', function (Blueprint $table) {
        $table->dropColumn([
            'gambar_pilihan_a',
            'gambar_pilihan_b',
            'gambar_pilihan_c',
            'gambar_pilihan_d'
        ]);
    });
}

};
