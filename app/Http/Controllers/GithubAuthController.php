<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function handleGithubCallback()
    {
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

        return redirect(env('APP_FRONTEND_URL') . '/?token=' . $token);
    }
}
