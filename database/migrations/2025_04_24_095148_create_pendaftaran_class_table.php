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
        Schema::create('pendaftaran_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('nohp');
            $table->unsignedBigInteger('id_jeniskelas');
            $table->unsignedInteger('kelas');
            $table->unsignedBigInteger('jenjang_pendidikan');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->json('jadwal_kelas'); // Menyimpan array ID jadwal (max 3)
            $table->unsignedBigInteger('id_jadwal_fix')->nullable(); // Akan diisi setelah konfirmasi
            $table->integer('harga'); // Diambil dari promosi_class
            $table->string('bukti_pembayaran')->nullable(); // Path bukti upload
            $table->timestamps();

            // Relasi
            $table->foreign('id_jeniskelas')->references('id_jeniskelas')->on('jenis_kelas')->onDelete('cascade');
            $table->foreign('jenjang_pendidikan')->references('id_jenjang_pendidikan')->on('jenjang_pendidikans')->onDelete('cascade');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajarans')->onDelete('cascade');
            $table->foreign('id_jadwal_fix')->references('id_jadwalkelas')->on('jadwal_kelas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran_class');
    }
};
