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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi');
            $table->text('fitur')->nullable(); // Bisa berupa bullet list
            $table->decimal('rating', 3, 2)->default(0);
            $table->string('instruktur');
            $table->string('durasi'); // contoh: "10 Jam", "8 Pertemuan"
            $table->string('level'); // contoh: "Beginner", "Intermediate"
            $table->decimal('harga', 10, 2); // contoh: 199.00
            $table->string('gambar')->nullable(); // <-- Tambahkan ini untuk thumbnail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};

