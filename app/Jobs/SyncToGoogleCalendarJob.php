<?php

namespace App\Jobs;

use App\Models\Pekerjaan;
use App\Models\User;
use App\Services\GoogleCalendarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncToGoogleCalendarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    protected string $action; // 'create', 'update', 'delete'
    public int $timeout = 60;
    public int $tries = 3;

    public function __construct(
        protected Pekerjaan $pekerjaan,
        string $action = 'create'
    ) {
        $this->action = $action;
    }

    public function handle(): void
    {
        try {
            // Skip jika user tidak authorize Google Calendar
            if (!$this->pekerjaan->user?->google_calendar_token) {
                Log::warning('User not authorized for Google Calendar', [
                    'user_id' => $this->pekerjaan->user_id,
                ]);
                return;
            }

            $service = new GoogleCalendarService();
            $service->setUserToken($this->pekerjaan->user);

            switch ($this->action) {
                case 'create':
                    $this->handleCreate($service);
                    break;
                case 'update':
                    $this->handleUpdate($service);
                    break;
                case 'delete':
                    $this->handleDelete($service);
                    break;
            }

            // Update sync status
            $this->pekerjaan->update([
                'sync_status' => 'synced',
                'google_calendar_synced_at' => now(),
                'sync_error' => null,
            ]);

            Log::info('Pekerjaan synced to Google Calendar', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'action' => $this->action,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to sync pekerjaan to Google Calendar', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'action' => $this->action,
                'error' => $e->getMessage(),
            ]);

            $this->pekerjaan->update([
                'sync_status' => 'failed',
                'sync_error' => $e->getMessage(),
            ]);

            // Retry atau fail
            if ($this->attempts() < $this->tries) {
                $this->release(delay: 60 * $this->attempts()); // Exponential backoff
            }
        }
    }

    private function handleCreate(GoogleCalendarService $service): void
    {
        if (!$this->pekerjaan->google_event_id) {
            $eventId = $service->createEvent($this->pekerjaan);
            if ($eventId) {
                $this->pekerjaan->update(['google_event_id' => $eventId]);
            }
        }
    }

    private function handleUpdate(GoogleCalendarService $service): void
    {
        if ($this->pekerjaan->google_event_id) {
            $service->updateEvent($this->pekerjaan);
        } else {
            // Jika belum ada event, create
            $eventId = $service->createEvent($this->pekerjaan);
            if ($eventId) {
                $this->pekerjaan->update(['google_event_id' => $eventId]);
            }
        }
    }

    private function handleDelete(GoogleCalendarService $service): void
    {
        if ($this->pekerjaan->google_event_id) {
            $service->deleteEvent($this->pekerjaan);
            $this->pekerjaan->update(['google_event_id' => null]);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('SyncToGoogleCalendarJob failed after retries', [
            'pekerjaan_id' => $this->pekerjaan->id,
            'exception' => $exception->getMessage(),
        ]);

        $this->pekerjaan->update([
            'sync_status' => 'failed',
            'sync_error' => 'Job gagal setelah ' . $this->tries . ' percobaan: ' . $exception->getMessage(),
        ]);
    }
}
