<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPendaftaranClassesTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_classes', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'selesai'])->default('aktif')->after('kelas_id');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_classes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
