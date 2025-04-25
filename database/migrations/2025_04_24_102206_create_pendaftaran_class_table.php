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
        Schema::create('pendaftaran_class', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('nohp');
            $table->unsignedBigInteger('id_jeniskelas');
            $table->integer('kelas');
            $table->unsignedBigInteger('jenjang_pendidikan');
            $table->unsignedBigInteger('mata_pelajaran');
            $table->unsignedBigInteger('jadwal_konfirmasi')->nullable(); // Jadwal yang dikonfirmasi admin
            $table->json('jadwal_pilihan'); // 3 pilihan jadwal
            $table->integer('harga');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_jeniskelas')->references('id_jeniskelas')->on('jenis_kelas');
            $table->foreign('jenjang_pendidikan')->references('id_jenjang_pendidikan')->on('jenjang_pendidikans');
            $table->foreign('mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajarans');
            $table->foreign('jadwal_konfirmasi')->references('id_jadwalkelas')->on('jadwal_kelas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran_class');
    }
};
