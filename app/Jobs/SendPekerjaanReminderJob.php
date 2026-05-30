<?php

namespace App\Jobs;

use App\Models\Notifikasi;
use App\Models\Pekerjaan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPekerjaanReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries = 2;

    public function __construct(protected Pekerjaan $pekerjaan, protected string $type = '1_day')
    {
        // Type: '1_day', '1_hour', 'on_day'
    }

    public function handle(): void
    {
        try {
            // Cek apakah sudah dikirim
            if ($this->isReminderAlreadySent()) {
                Log::info('Reminder already sent', [
                    'pekerjaan_id' => $this->pekerjaan->id,
                    'type' => $this->type,
                ]);
                return;
            }

            // Cek apakah waktu reminder sudah tepat
            if (!$this->isReminderTime()) {
                Log::info('Not reminder time yet', [
                    'pekerjaan_id' => $this->pekerjaan->id,
                    'type' => $this->type,
                ]);
                $this->release(delay: 60); // Retry dalam 1 menit
                return;
            }

            // Buat notifikasi
            $this->createNotifikasi();

            // Kirim email
            $this->sendEmailReminder();

            // Kirim in-app notification (jika ada queue untuk broadcast)
            $this->broadcastReminder();

            // Mark reminder as sent
            $this->markReminderAsSent();

            Log::info('Reminder sent successfully', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'type' => $this->type,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send reminder', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'type' => $this->type,
                'error' => $e->getMessage(),
            ]);

            if ($this->attempts() < $this->tries) {
                $this->release(delay: 300); // Retry dalam 5 menit
            }
        }
    }

    private function isReminderTime(): bool
    {
        $now = now();
        $pekerjaanDate = Carbon::parse($this->pekerjaan->tanggal);

        return match ($this->type) {
            '1_day' => $now->diffInHours($pekerjaanDate->startOfDay()) <= 24,
            '1_hour' => $now->diffInMinutes($pekerjaanDate->startOfDay()->addHours(8)) <= 60,
            'on_day' => $pekerjaanDate->isToday(),
            default => false,
        };
    }

    private function isReminderAlreadySent(): bool
    {
        return match ($this->type) {
            '1_day' => $this->pekerjaan->reminder_1_day,
            '1_hour' => $this->pekerjaan->reminder_1_hour,
            'on_day' => $this->pekerjaan->reminder_sent,
            default => false,
        };
    }

    private function createNotifikasi(): void
    {
        $messages = [
            '1_day' => "Reminder: Pekerjaan '{$this->pekerjaan->nama_pekerjaan}' akan dimulai besok",
            '1_hour' => "Reminder: Pekerjaan '{$this->pekerjaan->nama_pekerjaan}' akan dimulai dalam 1 jam",
            'on_day' => "Pekerjaan '{$this->pekerjaan->nama_pekerjaan}' dimulai hari ini",
        ];

        Notifikasi::create([
            'user_id' => $this->pekerjaan->user_id,
            'pesan' => $messages[$this->type] ?? 'Reminder pekerjaan',
            'tipe' => 'reminder_' . $this->type,
            'data' => json_encode([
                'pekerjaan_id' => $this->pekerjaan->id,
                'nama_pekerjaan' => $this->pekerjaan->nama_pekerjaan,
                'tanggal' => $this->pekerjaan->tanggal,
                'client' => $this->pekerjaan->client?->nama_client,
                'lokasi' => $this->pekerjaan->lokasi?->nama_lokasi,
            ]),
        ]);
    }

    private function sendEmailReminder(): void
    {
        try {
            if (!$this->pekerjaan->user?->email) {
                return;
            }

            $subject = match ($this->type) {
                '1_day' => '📅 Reminder: Pekerjaan besok',
                '1_hour' => '⏰ Reminder: Pekerjaan dalam 1 jam',
                'on_day' => '🚀 Pekerjaan hari ini',
                default => 'Reminder Pekerjaan',
            };

            $reminderType = match ($this->type) {
                '1_day' => 'Reminder H-1',
                '1_hour' => 'Reminder 1 Jam',
                'on_day' => 'Hari Ini',
                default => 'Reminder',
            };

            Mail::send('emails.reminder', [
                'pekerjaan' => $this->pekerjaan,
                'user' => $this->pekerjaan->user,
                'type' => $this->type,
                'reminderType' => $reminderType,
            ], function ($m) use ($subject) {
                $m->to($this->pekerjaan->user->email)
                  ->subject($subject);
            });

            Log::info('Email reminder sent', [
                'email' => $this->pekerjaan->user->email,
                'subject' => $subject,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send email reminder', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function broadcastReminder(): void
    {
        try {
            // Broadcast ke user channel menggunakan Laravel Broadcasting
            // broadcast(new PekerjaanReminderEvent($this->pekerjaan, $this->type));
            Log::info('Reminder broadcast', [
                'pekerjaan_id' => $this->pekerjaan->id,
                'user_id' => $this->pekerjaan->user_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to broadcast reminder', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function markReminderAsSent(): void
    {
        $update = ['last_reminder_at' => now()];

        switch ($this->type) {
            case '1_day':
                $update['reminder_1_day'] = true;
                break;
            case '1_hour':
                $update['reminder_1_hour'] = true;
                break;
            case 'on_day':
                $update['reminder_sent'] = true;
                break;
        }

        $this->pekerjaan->update($update);
    }

    private function buildEmailContent(): array
    {
        return [
            'pekerjaan' => $this->pekerjaan,
            'type' => $this->type,
            'tanggal' => Carbon::parse($this->pekerjaan->tanggal)->format('d M Y H:i'),
            'link' => route('pekerjaan.show', $this->pekerjaan->id),
        ];
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('SendPekerjaanReminderJob failed', [
            'pekerjaan_id' => $this->pekerjaan->id,
            'type' => $this->type,
            'exception' => $exception->getMessage(),
        ]);
    }
}
