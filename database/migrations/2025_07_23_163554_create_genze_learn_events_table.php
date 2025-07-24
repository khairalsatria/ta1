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
        Schema::create('genze_learn_events', function (Blueprint $table) {
    $table->id();
    $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
    $table->string('link_zoom')->nullable();
    $table->string('template_sertifikat')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genze_learn_events');
    }
};
