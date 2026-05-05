<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        // Don't auto-redirect here so they can login to the other account if they want.
        // Or we can be smart: if they are logged in as BOTH, redirect to admin.
        // But let's just let them see the login page so they can login to the other guard.
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                Auth::guard('admin')->login($user);
                return redirect('/admin/dashboard');
            } else {
                Auth::guard('web')->login($user);
                return redirect('/home');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function destroy(Request $request)
    {
        if (Auth::guard('admin')->check() && (request()->is('admin/*') || (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), '/admin')))) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }
        
        if (!Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/login');
    }
}   