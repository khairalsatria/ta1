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
        Schema::create('guide_hasil_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_guide_id')->constrained('pendaftaran_guide')->onDelete('cascade');
            $table->string('file_path');
            $table->unsignedBigInteger('uploaded_by')->nullable(); // ID Admin
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_hasil_files');
    }
};
