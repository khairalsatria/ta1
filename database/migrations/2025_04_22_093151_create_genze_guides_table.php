<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genze_guides', function (Blueprint $table) {
            $table->id('id_guide');
            $table->unsignedBigInteger('paket_guide');
            $table->unsignedBigInteger('jadwal_guide2')->nullable(); // nullable jika hanya muncul saat paket_guide == 2
            $table->string('file')->nullable();
            $table->integer('harga');
            $table->text('keterangan')->nullable();
            $table->string('link_zoom')->nullable();
            $table->timestamps();

            $table->foreign('paket_guide')->references('id_paket_guide')->on('paket_guides')->onDelete('cascade');
            $table->foreign('jadwal_guide2')->references('id_jadwalguide2')->on('jadwal_guide2')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genze_guides');
    }
};
