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
        Schema::create('promosi_class', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi');
            $table->text('benefit');
            $table->decimal('harga', 10, 2);
            $table->string('gambar')->nullable(); // Gambar bisa null
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promosi_class');
    }
};
