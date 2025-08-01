<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\RegisteredUser; // Or the correct namespace for RegisteredUser if it's an event.
use Illuminate\Support\Facades\Auth;;

class GoogleAuthController extends Controller
{
    public function GoogleAuth()
    {
       return Socialite::driver('google')->redirect();
    }

    public function Google_CallBack()
    {  
         try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Something went wrong. Try again.');
        }

        $user = User::where('google_id', $googleUser->getId())->first();


        if(!$user){
            $user = User::where('email', $googleUser->email)->first();
            if (!$user){
                $user = tap(User::create([
                    'name'=> $googleUser->name,
                    'email'=> $googleUser->email,
                    'password'=> password_hash(Hash::make(\Str::random(16)), PASSWORD_DEFAULT),
                    'google_id'=> $googleUser->id,
                    'google_token'=> $googleUser->token,
                    'google_refresh_token'=> $googleUser->refreshToken,
                    'google_avatar'=> $googleUser->avatar]), 
                     function(User $user){
                        $user->markEmailAsVerified();
                    });
                    event(new Registered($user));
                    Auth::login($user);
                    return app(RegisterResponse::class);
            }
            $user->update([
                'google_id' => $googleUser->id,
                'google_avatar' => $googleUser->avatar
            ]);
        }
        $user->update([
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken
        ]);
        Auth::login($user, true);
        return view('home');
    }
}
