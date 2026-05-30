<?php

namespace App\Console\Commands;

use App\Jobs\SendPekerjaanReminderJob;
use App\Models\Pekerjaan;
use Illuminate\Console\Command;

class SendReminderCommand extends Command
{
    protected $signature = 'reminder:send 
                            {--pekerjaan-id= : Pekerjaan ID}
                            {--type=1_day : Tipe reminder (1_day, 1_hour, on_day)}
                            {--dry-run : Preview tanpa execute}
                          ';

    protected $description = 'Send manual reminder untuk pekerjaan';

    public function handle()
    {
        try {
            if (!$this->option('pekerjaan-id')) {
                return $this->sendBatch();
            }

            return $this->sendSpecific();

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    private function sendSpecific(): int
    {
        $id = $this->option('pekerjaan-id');
        $type = $this->option('type');

        $pekerjaan = Pekerjaan::find($id);

        if (!$pekerjaan) {
            $this->error("Pekerjaan dengan ID $id tidak ditemukan");
            return 1;
        }

        $this->info("Sending reminder type '$type' untuk: {$pekerjaan->nama_pekerjaan}");

        if ($this->option('dry-run')) {
            $this->line("[DRY RUN] Akan kirim reminder:");
            $this->line("  Pekerjaan: {$pekerjaan->nama_pekerjaan}");
            $this->line("  Tanggal: {$pekerjaan->tanggal->format('d M Y')}");
            $this->line("  Tipe: $type");
            return 0;
        }

        SendPekerjaanReminderJob::dispatch($pekerjaan, $type);
        $this->info("✅ Reminder berhasil dijadwalkan");

        return 0;
    }

    private function sendBatch(): int
    {
        $date = now()->addDay();
        $pekerjaans = Pekerjaan::whereDate('tanggal', $date->toDateString())->get();

        if ($pekerjaans->isEmpty()) {
            $this->info("Tidak ada pekerjaan untuk tanggal {$date->format('d M Y')}");
            return 0;
        }

        $type = $this->option('type');
        $this->info("Sending '{$type}' reminders untuk {$pekerjaans->count()} pekerjaan");

        if ($this->option('dry-run')) {
            foreach ($pekerjaans as $p) {
                $this->line("  [DRY RUN] {$p->nama_pekerjaan} ({$p->tanggal->format('d M Y')})");
            }
            return 0;
        }

        foreach ($pekerjaans as $pekerjaan) {
            SendPekerjaanReminderJob::dispatch($pekerjaan, $type);
            $this->line("  ✓ {$pekerjaan->nama_pekerjaan}");
        }

        $this->info("✅ Semua reminder berhasil dijadwalkan");
        return 0;
    }
}
