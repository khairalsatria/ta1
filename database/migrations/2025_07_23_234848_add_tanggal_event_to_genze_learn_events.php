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
    Schema::table('genze_learn_events', function (Blueprint $table) {
        $table->date('tanggal_event')->nullable()->after('link_zoom');
        $table->time('jam_event')->nullable()->after('tanggal_event');
    });
}

public function down()
{
    Schema::table('genze_learn_events', function (Blueprint $table) {
        $table->dropColumn(['tanggal_event', 'jam_event']);
    });
}
};
