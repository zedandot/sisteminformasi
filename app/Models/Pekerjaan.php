<?php

namespace App\Models;

use App\Jobs\SendPekerjaanReminderJob;
use App\Jobs\SyncToGoogleCalendarJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Events\Created;
use Illuminate\Database\Eloquent\Events\Updated;
use Illuminate\Database\Eloquent\Events\Deleted;

class Pekerjaan extends Model
{

    protected $guarded = [];
    
    protected $casts = [
        'tanggal' => 'date',
        'notification_settings' => 'json',
    ];

    protected static function booted(): void
    {
        static::created(function (Pekerjaan $pekerjaan) {
            // Sync ke Google Calendar
            SyncToGoogleCalendarJob::dispatch($pekerjaan, 'create')->onQueue('default');
            
            // Schedule reminders
            $pekerjaan->scheduleReminders();
        });

        static::updated(function (Pekerjaan $pekerjaan) {
            // Jika tanggal berubah, sync ke Google Calendar
            if ($pekerjaan->isDirty(['tanggal', 'nama_pekerjaan'])) {
                SyncToGoogleCalendarJob::dispatch($pekerjaan, 'update')->onQueue('default');
                
                // Reset reminder flags jika tanggal berubah
                if ($pekerjaan->isDirty('tanggal')) {
                    $pekerjaan->update([
                        'reminder_1_day' => false,
                        'reminder_1_hour' => false,
                        'reminder_sent' => false,
                    ]);
                    $pekerjaan->scheduleReminders();
                }
            }
        });

        static::deleted(function (Pekerjaan $pekerjaan) {
            // Hapus dari Google Calendar
            SyncToGoogleCalendarJob::dispatch($pekerjaan, 'delete')->onQueue('default');
        });
    }

    public function laporans() {
        return $this->hasMany(Laporan::class);
    }

    public function lokasi() {
        return $this->belongsTo(Lokasi::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Schedule reminders untuk pekerjaan ini
     */
    public function scheduleReminders(): void
    {
        if (!$this->user_id || !$this->user?->google_calendar_token) {
            return;
        }

        $tanggal = Carbon::parse($this->tanggal);
        $now = now();

        // Schedule reminder 1 hari sebelumnya
        if ($now->lt($tanggal->subDay())) {
            SendPekerjaanReminderJob::dispatch($this, '1_day')
                ->delay($tanggal->subDay()->startOfDay())
                ->onQueue('reminders');
        }

        // Schedule reminder 1 jam sebelumnya
        $oneDayBefore = Carbon::parse($this->tanggal)->subDay();
        if ($now->lt($oneDayBefore->startOfDay()->addHours(8))) {
            SendPekerjaanReminderJob::dispatch($this, '1_hour')
                ->delay($oneDayBefore->startOfDay()->addHours(7))
                ->onQueue('reminders');
        }

        // Schedule reminder di hari kerja
        if ($now->lt($tanggal->startOfDay())) {
            SendPekerjaanReminderJob::dispatch($this, 'on_day')
                ->delay($tanggal->startOfDay()->addHours(6))
                ->onQueue('reminders');
        }
    }

    /**
     * Get sync status badge
     */
    public function getSyncStatusBadgeAttribute(): string
    {
        return match ($this->sync_status) {
            'synced' => '✅ Tersinkronisasi',
            'pending' => '⏳ Menunggu',
            'failed' => '❌ Gagal',
            default => '❓ Tidak diketahui',
        };
    }

    /**
     * Check apakah sudah sync ke Google Calendar
     */
    public function isSynced(): bool
    {
        return $this->sync_status === 'synced' && !empty($this->google_event_id);
    }

    /**
     * Manual sync ke Google Calendar
     */
    public function syncToGoogleCalendar(): void
    {
        SyncToGoogleCalendarJob::dispatch($this, 'update')->onQueue('default');
    }

    /**
     * Manual send reminder
     */
    public function sendReminder(string $type = '1_day'): void
    {
        SendPekerjaanReminderJob::dispatch($this, $type)->onQueue('reminders');
    }
}
