<?php

// database/migrations/xxxx_xx_xx_add_alternatif_jadwal_to_pendaftaran_classes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlternatifJadwalToPendaftaranClassesTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('jadwalkelas_alternatif')->nullable()->after('jadwalkelas_konfirmasi');
            $table->enum('status_alternatif', ['ditawarkan', 'diterima', 'ditolak'])->nullable()->after('jadwalkelas_alternatif');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_classes', function (Blueprint $table) {
            $table->dropColumn(['jadwalkelas_alternatif', 'status_alternatif']);
        });
    }
}

