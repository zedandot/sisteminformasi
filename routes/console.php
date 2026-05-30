<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Google Calendar: Sync pending pekerjaan setiap 15 menit
Schedule::command('google-calendar:sync')->everyFifteenMinutes();

// Reminder: Kirim H-1 setiap hari jam 06:00
Schedule::command('reminder:send --type=1_day')->dailyAt('06:00');

// Reminder: Kirim 1 jam sebelum, cek setiap jam pada jam kerja
Schedule::command('reminder:send --type=1_hour')->hourly()->between('07:00', '17:00');

// Reminder: Kirim di hari kerja jam 06:00
Schedule::command('reminder:send --type=on_day')->dailyAt('06:00');
