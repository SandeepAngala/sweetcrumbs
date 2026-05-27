<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Google OAuth callback failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }

        // Look for an existing user by google_id first, then by email
        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            // Check if a user with this email already exists (registered via email/password)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link the existing account with Google credentials
                $user->update([
                    'google_id'     => $googleUser->getId(),
                    'avatar'        => $googleUser->getAvatar() ?? $user->avatar,
                    'auth_provider' => $user->auth_provider ?? 'google',
                ]);
            } else {
                // Create a brand-new user from the Google profile
                $user = User::create([
                    'name'          => $googleUser->getName(),
                    'email'         => $googleUser->getEmail(),
                    'google_id'     => $googleUser->getId(),
                    'avatar'        => $googleUser->getAvatar(),
                    'auth_provider' => 'google',
                    'role'          => 'customer',
                    'password'      => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                ]);
            }
        } else {
            // Returning Google user — update avatar in case it changed
            $user->update([
                'avatar' => $googleUser->getAvatar() ?? $user->avatar,
            ]);
        }

        // Log the user in with "remember me" enabled for persistent sessions
        Auth::login($user, true);

        // Regenerate the session to prevent fixation attacks
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Welcome, ' . $user->name . '!');
    }
}
