<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guide_hasil_files', function (Blueprint $table) {
            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); // atau 'cascade' tergantung logikamu
        });
    }

    public function down(): void
    {
        Schema::table('guide_hasil_files', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
        });
    }
};

