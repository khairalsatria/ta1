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
        Schema::create('kelas_genze', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('kuota')->default(10);
            $table->text('deskripsi')->nullable();
            $table->string('link_zoom_default')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_genze');
    }
};
