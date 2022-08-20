<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectForAuthentication()
    {
        return Socialite::driver('laravelpassport')->redirect();
    }

    public function handleCallbackForAuthentication()
    {
        $oauthUser = Socialite::driver('laravelpassport')->user();

        $user = User::updateOrCreate([
            'oauth_user_id' => $oauthUser->id,
        ], [
            'name' => $oauthUser->name,
            'email' => $oauthUser->email,
            'oauth_token' => $oauthUser->token,
            'oauth_refresh_token' => $oauthUser->refreshToken,
            'oauth_token_expires_in' => $oauthUser->expiresIn,
        ]);

        Auth::login($user);
        return redirect()->route('index');
    }

    public function logout()
    {
        $user = User::findOrFail(Auth::id());
        Http::withToken($user->oauth_token)->get(env('LARAVEL_PASSPORT_HOST') . '/api/logout')->json();

        Auth::logout();
        return redirect()->route('index');
    }
}
