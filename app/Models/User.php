<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'google_calendar_token', 'google_calendar_refresh_token', 'google_calendar_authorized_at'])]
#[Hidden(['password', 'remember_token', 'google_calendar_token', 'google_calendar_refresh_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function laporans() {
        return $this->hasMany(Laporan::class);
    }

    public function pekerjaans() {
        return $this->hasMany(Pekerjaan::class);
    }

    public function notifikasis() {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check apakah user sudah authorize Google Calendar
     */
    public function hasGoogleCalendarAuthorization(): bool
    {
        return !empty($this->google_calendar_token);
    }

    /**
     * Revoke Google Calendar authorization
     */
    public function revokeGoogleCalendarAuthorization(): void
    {
        $this->update([
            'google_calendar_token' => null,
            'google_calendar_refresh_token' => null,
        ]);
    }
}
