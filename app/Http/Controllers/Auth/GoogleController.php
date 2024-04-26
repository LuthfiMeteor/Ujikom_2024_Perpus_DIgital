<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        // dd($user);
        if (Auth::check()) {
            if (!Auth::user()->google_id) {
                $connected_user = User::find(Auth::id());
                if ($user->email != $connected_user->email) {
                    return redirect()->route('profilUser')->withErrors(['googlenotsame' => 'Google Akun Tidak Sesuai Dengan Email Akun Saat Ini.']);
                }
                $connected_user->google_id = $user->id;
                $connected_user->update();
                return redirect(route('profilUser'));
            } else {
                $connected_user = User::find(Auth::id());
                // dd($connected_user);
                if ($user->email != $connected_user->email) {
                    return redirect()->route('profilUser')->withErrors(['googlenotsame' => 'Google Akun Tidak Sesuai Dengan Email Akun Saat Ini.']);
                }
                $connected_user->google_id = null;
                $connected_user->update();
                return redirect(route('profilUser'));
            }
        } else {
            // dd($user);
            $authUser = User::where('google_id', $user->id)->first();
            $checkEmail = User::where('email', $user->email)->first();
            if ($checkEmail && !$checkEmail->google_id) {
                return redirect()
                    ->route('login')
                    ->withErrors(['google' => 'Kesalahan Silahkan Mencoba Dengan Metode Login Lainnya.']);
            }
            if (!$authUser) {
                $authUser = User::create([
                    'google_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $authUser->assignRole('user');
                Auth::login($authUser, true);
                return redirect()->route('landingPage');
            }
            Auth::login($authUser, true);
            return redirect()->intended('/');
        }
    }
    public function googleConnect()
    {
        return Socialite::driver('google')->redirect();
    }
}
