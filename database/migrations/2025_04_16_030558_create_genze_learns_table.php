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
        Schema::create('genze_learns', function (Blueprint $table) {
            $table->id('id_learn');
            $table->string('nama_learn');
            $table->string('pembicara');
            $table->dateTime('jadwal');
            $table->decimal('harga', 10, 2)->nullable(); // Mengubah harga menjadi nullable
            $table->text('keterangan')->nullable();
            $table->string('link_zoom')->nullable();
            $table->string('sertifikat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genze_learns');
    }
};
