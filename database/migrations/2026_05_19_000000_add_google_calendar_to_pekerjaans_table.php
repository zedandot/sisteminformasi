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
        Schema::table('pekerjaans', function (Blueprint $table) {
            // Google Calendar Integration
            $table->string('google_event_id')->nullable()->unique();
            $table->enum('sync_status', ['pending', 'synced', 'failed'])->default('pending');
            $table->text('sync_error')->nullable();
            $table->timestamp('google_calendar_synced_at')->nullable();
            
            // Reminder Tracking
            $table->boolean('reminder_sent')->default(false);
            $table->boolean('reminder_1_day')->default(false);
            $table->boolean('reminder_1_hour')->default(false);
            $table->timestamp('last_reminder_at')->nullable();
            
            // Notification Settings
            $table->json('notification_settings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->dropColumn([
                'google_event_id',
                'sync_status',
                'sync_error',
                'google_calendar_synced_at',
                'reminder_sent',
                'reminder_1_day',
                'reminder_1_hour',
                'last_reminder_at',
                'notification_settings'
            ]);
        });
    }
};
