<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nohp')->nullable()->after('email');
            $table->string('role')->default('user')->after('nohp');
            $table->string('photo')->nullable()->after('role');
            $table->string('google_id')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nohp', 'role', 'photo', 'google_id']);
        });
    }
};
