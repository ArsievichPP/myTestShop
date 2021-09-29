<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use SebastianBergmann\Diff\Exception;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function loginWithGoogle()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $isUser = User::query()->where('google_id', $user->id)->first();
            if ($isUser) {
                Auth::login($isUser);
                return redirect(route('main'));
            } else {
                $newUser = User::create(
                    [
                        'name' => $user->name,
                        'phone' => '',
                        'address' => '',
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'password' => encrypt(rand(9999, 999999999))
                    ]);
                Auth::login($newUser);
                return redirect(route('main'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
