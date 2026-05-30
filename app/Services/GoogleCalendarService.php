<?php

namespace App\Services;

use App\Models\Pekerjaan;
use App\Models\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_EventReminder;
use Google_Service_Calendar_EventReminders;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    private Google_Client $client;
    private Google_Service_Calendar $calendarService;
    private ?string $calendarId = null;

    public function __construct()
    {
        $this->client = new Google_Client();

        // Configure from config/google-calendar.php or env
        $this->client->setClientId(config('services.google.calendar.client_id'));
        $this->client->setClientSecret(config('services.google.calendar.client_secret'));
        $this->client->setRedirectUri(config('services.google.calendar.redirect_uri'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

        $this->calendarService = new Google_Service_Calendar($this->client);
        $this->calendarId = config('services.google.calendar.calendar_id', 'primary');
    }

    /**
     * Set user's access token
     */
    public function setUserToken(User $user): self
    {
        if ($user->google_calendar_token) {
            $this->client->setAccessToken(json_decode($user->google_calendar_token, true));

            // Refresh token jika sudah kadaluarsa
            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update(['google_calendar_token' => json_encode($this->client->getAccessToken())]);
            }
        }

        return $this;
    }

    /**
     * Create event di Google Calendar
     */
    public function createEvent(Pekerjaan $pekerjaan): ?string
    {
        try {
            $event = new Google_Service_Calendar_Event();
            $event->setSummary($pekerjaan->nama_pekerjaan);
            $event->setDescription($this->buildEventDescription($pekerjaan));

            $tanggal = Carbon::parse($pekerjaan->tanggal)->format('Y-m-d');

            // Set waktu event
            $startTime = new Google_Service_Calendar_EventDateTime();
            $startTime->setDateTime($tanggal . 'T08:00:00');
            $startTime->setTimeZone('Asia/Jakarta');
            $event->setStart($startTime);

            $endTime = new Google_Service_Calendar_EventDateTime();
            $endTime->setDateTime($tanggal . 'T17:00:00');
            $endTime->setTimeZone('Asia/Jakarta');
            $event->setEnd($endTime);

            // Set reminders
            $remindersData = [
                ['method' => 'popup', 'minutes' => 60],      // 1 jam
                ['method' => 'email', 'minutes' => 1440],    // 1 hari
                ['method' => 'popup', 'minutes' => 15],      // 15 menit
            ];

            $eventReminders = new Google_Service_Calendar_EventReminders();
            $eventReminders->setUseDefault(false);

            $overrides = [];
            foreach ($remindersData as $r) {
                $reminder = new Google_Service_Calendar_EventReminder();
                $reminder->setMethod($r['method']);
                $reminder->setMinutes($r['minutes']);
                $overrides[] = $reminder;
            }
            $eventReminders->setOverrides($overrides);
            $event->setReminders($eventReminders);

            // Tambah lokasi
            if ($pekerjaan->lokasi) {
                $event->setLocation($pekerjaan->lokasi->nama_lokasi);
            }

            // Tambah attachment (link ke aplikasi)
            $event->setDescription(
                $this->buildEventDescription($pekerjaan)
            );

            // Create event
            $createdEvent = $this->calendarService->events->insert(
                $this->calendarId,
                $event
            );

            Log::info('Google Calendar event created', [
                'pekerjaan_id' => $pekerjaan->id,
                'google_event_id' => $createdEvent->getId(),
            ]);

            return $createdEvent->getId();

        } catch (\Exception $e) {
            Log::error('Failed to create Google Calendar event', [
                'pekerjaan_id' => $pekerjaan->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Update event di Google Calendar
     */
    public function updateEvent(Pekerjaan $pekerjaan): bool
    {
        try {
            if (!$pekerjaan->google_event_id) {
                return false;
            }

            $event = $this->calendarService->events->get(
                $this->calendarId,
                $pekerjaan->google_event_id
            );

            $event->setSummary($pekerjaan->nama_pekerjaan);
            $event->setDescription($this->buildEventDescription($pekerjaan));

            $tanggal = Carbon::parse($pekerjaan->tanggal)->format('Y-m-d');

            // Update waktu
            $startTime = new Google_Service_Calendar_EventDateTime();
            $startTime->setDateTime($tanggal . 'T08:00:00');
            $startTime->setTimeZone('Asia/Jakarta');
            $event->setStart($startTime);

            $endTime = new Google_Service_Calendar_EventDateTime();
            $endTime->setDateTime($tanggal . 'T17:00:00');
            $endTime->setTimeZone('Asia/Jakarta');
            $event->setEnd($endTime);

            $this->calendarService->events->update(
                $this->calendarId,
                $pekerjaan->google_event_id,
                $event
            );

            Log::info('Google Calendar event updated', [
                'pekerjaan_id' => $pekerjaan->id,
                'google_event_id' => $pekerjaan->google_event_id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to update Google Calendar event', [
                'pekerjaan_id' => $pekerjaan->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Delete event dari Google Calendar
     */
    public function deleteEvent(Pekerjaan $pekerjaan): bool
    {
        try {
            if (!$pekerjaan->google_event_id) {
                return false;
            }

            $this->calendarService->events->delete(
                $this->calendarId,
                $pekerjaan->google_event_id
            );

            Log::info('Google Calendar event deleted', [
                'pekerjaan_id' => $pekerjaan->id,
                'google_event_id' => $pekerjaan->google_event_id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to delete Google Calendar event', [
                'pekerjaan_id' => $pekerjaan->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get list events untuk tanggal tertentu
     */
    public function getEventsForDate(string $date): array
    {
        try {
            $startOfDay = Carbon::parse($date)->startOfDay()->toRfc3339String();
            $endOfDay = Carbon::parse($date)->endOfDay()->toRfc3339String();

            $events = $this->calendarService->events->listEvents(
                $this->calendarId,
                [
                    'timeMin' => $startOfDay,
                    'timeMax' => $endOfDay,
                    'singleEvents' => true,
                    'orderBy' => 'startTime',
                ]
            );

            return $events->getItems() ?? [];

        } catch (\Exception $e) {
            Log::error('Failed to get Google Calendar events', [
                'date' => $date,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Build event description
     */
    private function buildEventDescription(Pekerjaan $pekerjaan): string
    {
        $description = "📋 Pekerjaan: {$pekerjaan->nama_pekerjaan}\n";

        if ($pekerjaan->client) {
            $description .= "👤 Client: {$pekerjaan->client->nama_client}\n";
        }

        if ($pekerjaan->lokasi) {
            $description .= "📍 Lokasi: {$pekerjaan->lokasi->nama_lokasi}\n";
        }

        if ($pekerjaan->user) {
            $description .= "👨‍💼 PIC: {$pekerjaan->user->name}\n";
        }

        $description .= "\n🔗 Link: " . route('pekerjaan.show', $pekerjaan->id) . "\n";

        return $description;
    }

    /**
     * Get authorization URL untuk user login
     */
    public function getAuthorizationUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle authorization callback
     */
    public function handleAuthorizationCallback(string $code): ?array
    {
        try {
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Failed to handle Google Calendar authorization', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
