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
            $table->longText('google_calendar_token')->nullable();
            $table->longText('google_calendar_refresh_token')->nullable();
            $table->timestamp('google_calendar_authorized_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_calendar_token',
                'google_calendar_refresh_token',
                'google_calendar_authorized_at',
            ]);
        });
    }
};
