<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalPertemuanToMateriPertemuanTable extends Migration
{
    public function up()
    {
        Schema::table('materi_pertemuans', function (Blueprint $table) {
            $table->dateTime('tanggal_pertemuan')->nullable()->after('kelas_id');
        });
    }

    public function down()
    {
        Schema::table('materi_pertemuans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pertemuan');
        });
    }
}
