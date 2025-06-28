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
       Schema::create('materi_pertemuans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kelas_id')->constrained('kelas_genze')->onDelete('cascade');
    $table->integer('pertemuan_ke');
    $table->string('judul');
    $table->string('file_pdf')->nullable();
    $table->string('link_zoom')->nullable();
    $table->string('link_rekaman')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_pertemuans');
    }
};
