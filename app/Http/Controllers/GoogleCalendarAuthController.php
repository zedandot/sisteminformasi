<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GoogleCalendarAuthController extends Controller
{
    /**
     * Show authorization page
     */
    public function show(): View
    {
        return view('google-calendar.authorize');
    }

    /**
     * Redirect user ke Google untuk authorize
     */
    public function authorize(): RedirectResponse
    {
        $service = new GoogleCalendarService();
        $authUrl = $service->getAuthorizationUrl();

        return redirect()->away($authUrl);
    }

    /**
     * Handle callback dari Google
     */
    public function callback(): RedirectResponse
    {
        $code = request('code');
        $error = request('error');

        if ($error) {
            return redirect()->route('google-calendar.show')
                ->with('error', 'Google Calendar authorization dibatalkan: ' . $error);
        }

        if (!$code) {
            return redirect()->route('google-calendar.show')
                ->with('error', 'Kode autorisasi tidak ditemukan');
        }

        try {
            $service = new GoogleCalendarService();
            $accessToken = $service->handleAuthorizationCallback($code);

            if (!$accessToken) {
                return redirect()->route('google-calendar.show')
                    ->with('error', 'Gagal mendapatkan access token');
            }

            // Simpan token ke user
            auth()->user()->update([
                'google_calendar_token' => json_encode($accessToken),
                'google_calendar_authorized_at' => now(),
            ]);

            return redirect()->route('google-calendar.show')
                ->with('success', '✅ Google Calendar berhasil diautentikasi!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Calendar callback error', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('google-calendar.show')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Revoke authorization
     */
    public function revoke(): RedirectResponse
    {
        auth()->user()->revokeGoogleCalendarAuthorization();

        return redirect()->route('google-calendar.show')
            ->with('success', 'Google Calendar authorization telah dihapus');
    }
}
