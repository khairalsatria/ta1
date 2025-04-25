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
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id('id_mata_pelajaran');
            $table->string('mata_pelajaran');
            $table->foreignId('jenjang_pendidikan')->constrained('jenjang_pendidikans', 'id_jenjang_pendidikan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
