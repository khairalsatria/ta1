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
    Schema::table('pendaftaran_class', function (Blueprint $table) {
        $table->string('status_pembayaran')->default('menunggu')->after('bukti_pembayaran');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_class', function (Blueprint $table) {
            //
        });
    }
};
