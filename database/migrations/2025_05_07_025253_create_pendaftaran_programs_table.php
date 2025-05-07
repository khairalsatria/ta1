<?php

// Migration: create_pendaftaran_programs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipe_program')->constrained('programs')->onDelete('cascade');
            $table->decimal('harga', 10, 2); // Harga dari tabel programs saat pendaftaran
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });

        Schema::create('pendaftaran_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_programs')->onDelete('cascade');
            $table->unsignedBigInteger('jeniskelas');
            $table->unsignedInteger('kelas');
            $table->unsignedBigInteger('jenjang_pendidikan');
            $table->unsignedBigInteger('mata_pelajaran');
            $table->json('jadwalkelas_pilihan'); // Menyimpan array ID jadwal (max 3)
            $table->unsignedBigInteger('jadwalkelas_konfirmasi')->nullable(); // Akan diisi setelah konfirmasi
            $table->timestamps();

            // Relasi
            $table->foreign('jeniskelas')->references('id_jeniskelas')->on('jenis_kelas')->onDelete('cascade');
            $table->foreign('jenjang_pendidikan')->references('id_jenjang_pendidikan')->on('jenjang_pendidikans')->onDelete('cascade');
            $table->foreign('mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajarans')->onDelete('cascade');
            $table->foreign('jadwalkelas_konfirmasi')->references('id_jadwalkelas')->on('jadwal_kelas')->onDelete('set null');
        });

        Schema::create('pendaftaran_guide', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_programs')->onDelete('cascade');
            $table->unsignedBigInteger('paketguides');
            $table->string('file_upload')->nullable();
            $table->json('jadwalguide2_pilihan'); // Menyimpan array ID jadwal (max 3)
            $table->unsignedBigInteger('jadwalguide2_konfirmasi')->nullable(); // Akan diisi setelah konfirmasi
            $table->timestamps();

            $table->foreign('paketguides')->references('id_paket_guide')->on('paket_guides')->onDelete('cascade');
            $table->foreign('jadwalguide2_konfirmasi')->references('id_jadwalguide2')->on('jadwal_guide2')->onDelete('set null');
        });

        Schema::create('pendaftaran_learns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_programs')->onDelete('cascade');
            $table->string('asal_instansi');
            $table->string('sertifikat')->nullable(); // path ke sertifikat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_learns');
        Schema::dropIfExists('pendaftaran_guides');
        Schema::dropIfExists('pendaftaran_classes');
        Schema::dropIfExists('pendaftaran_programs');
    }
};
