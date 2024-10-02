<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

Route::get('/api/auth/github', function () {
    return Socialite::driver('github')->stateless()->redirect();
});

Route::get('/api/auth/github/callback', function () {
    // Obtener el usuario de GitHub después de la autenticación
    $githubUser = Socialite::driver('github')->stateless()->user();

    // Logic for user creation and token generation goes here
    $user = User::firstOrCreate([
        'github_id' => $githubUser->getId(),
    ], [
        'name' => $githubUser->getName(),
        'nickname' => $githubUser->getNickname(),
        'email' => $githubUser->getEmail(),
        'avatar' => $githubUser->getAvatar(),
        'password' => Hash::make(Str::random(12))
    ]);

    // Generate API token
    $token = $user->createToken('github-auth-token')->plainTextToken;

    return response()->json(['token' => $token]);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/api', function () {
    return response()->json(['status' => 200]);
});