<?php

namespace App\Console\Commands;

use App\Models\Pekerjaan;
use App\Models\User;
use Illuminate\Console\Command;

class GoogleCalendarSyncCommand extends Command
{
    protected $signature = 'google-calendar:sync 
                            {--user-id= : User ID to sync}
                            {--pekerjaan-id= : Pekerjaan ID to sync}
                            {--force : Force sync bahkan jika sudah synced}
                            {--resync-all : Resync semua pekerjaan}
                            {--dry-run : Preview tanpa execute}
                          ';

    protected $description = 'Sync pekerjaan ke Google Calendar';

    public function handle()
    {
        try {
            if ($this->option('resync-all')) {
                return $this->resyncAll();
            }

            if ($this->option('pekerjaan-id')) {
                return $this->syncPekerjaan();
            }

            if ($this->option('user-id')) {
                return $this->syncByUser();
            }

            $this->syncPending();

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    private function syncPekerjaan(): int
    {
        $id = $this->option('pekerjaan-id');
        $pekerjaan = Pekerjaan::find($id);

        if (!$pekerjaan) {
            $this->error("Pekerjaan dengan ID $id tidak ditemukan");
            return 1;
        }

        if (!$pekerjaan->user?->hasGoogleCalendarAuthorization()) {
            $this->error("User tidak authorize Google Calendar");
            return 1;
        }

        $this->info("Syncing pekerjaan: {$pekerjaan->nama_pekerjaan}");

        if ($this->option('dry-run')) {
            $this->line("  [DRY RUN] Akan sync: {$pekerjaan->nama_pekerjaan}");
            return 0;
        }

        $pekerjaan->syncToGoogleCalendar();
        $this->info("✅ Pekerjaan berhasil dijadwalkan untuk sync");

        return 0;
    }

    private function syncByUser(): int
    {
        $userId = $this->option('user-id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User dengan ID $userId tidak ditemukan");
            return 1;
        }

        if (!$user->hasGoogleCalendarAuthorization()) {
            $this->error("User tidak authorize Google Calendar");
            return 1;
        }

        $pekerjaans = $user->pekerjaans()
            ->where(function ($q) {
                if (!$this->option('force')) {
                    $q->where('sync_status', '!=', 'synced');
                }
            })
            ->get();

        if ($pekerjaans->isEmpty()) {
            $this->info("Tidak ada pekerjaan untuk disync");
            return 0;
        }

        $this->info("Syncing {$pekerjaans->count()} pekerjaan untuk user: {$user->name}");

        if ($this->option('dry-run')) {
            foreach ($pekerjaans as $p) {
                $this->line("  [DRY RUN] {$p->nama_pekerjaan} - Status: {$p->sync_status}");
            }
            return 0;
        }

        foreach ($pekerjaans as $pekerjaan) {
            $pekerjaan->syncToGoogleCalendar();
            $this->line("  ✓ {$pekerjaan->nama_pekerjaan}");
        }

        $this->info("✅ Semua pekerjaan berhasil dijadwalkan");
        return 0;
    }

    private function syncPending(): int
    {
        $pekerjaans = Pekerjaan::where('sync_status', 'pending')
            ->orWhere('sync_status', 'failed')
            ->get();

        if ($pekerjaans->isEmpty()) {
            $this->info("Tidak ada pekerjaan yang pending");
            return 0;
        }

        $this->info("Syncing {$pekerjaans->count()} pekerjaan yang pending");

        if ($this->option('dry-run')) {
            foreach ($pekerjaans as $p) {
                $this->line("  [DRY RUN] {$p->nama_pekerjaan} - Status: {$p->sync_status}");
            }
            return 0;
        }

        $synced = 0;
        $failed = 0;

        foreach ($pekerjaans as $pekerjaan) {
            if (!$pekerjaan->user?->hasGoogleCalendarAuthorization()) {
                $this->line("  ✗ {$pekerjaan->nama_pekerjaan} - User tidak authorize");
                $failed++;
                continue;
            }

            $pekerjaan->syncToGoogleCalendar();
            $this->line("  ✓ {$pekerjaan->nama_pekerjaan}");
            $synced++;
        }

        $this->info("✅ Berhasil: $synced, Gagal: $failed");
        return 0;
    }

    private function resyncAll(): int
    {
        $pekerjaans = Pekerjaan::whereNotNull('google_event_id')->get();

        if ($pekerjaans->isEmpty()) {
            $this->info("Tidak ada pekerjaan yang tersync");
            return 0;
        }

        $this->warn("Akan resync {$pekerjaans->count()} pekerjaan!");
        if (!$this->confirm('Lanjutkan?')) {
            return 0;
        }

        if ($this->option('dry-run')) {
            foreach ($pekerjaans as $p) {
                $this->line("  [DRY RUN] {$p->nama_pekerjaan} - Google Event ID: {$p->google_event_id}");
            }
            return 0;
        }

        foreach ($pekerjaans as $pekerjaan) {
            $pekerjaan->update(['sync_status' => 'pending']);
            $pekerjaan->syncToGoogleCalendar();
            $this->line("  ✓ {$pekerjaan->nama_pekerjaan}");
        }

        $this->info("✅ Semua pekerjaan berhasil dijadwalkan untuk resync");
        return 0;
    }
}
