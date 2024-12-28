<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    public function loginSocial(Request $request, string $provider): RedirectResponse
    {
        $this->validateProvider($request);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callbackSocial(Request $request, string $provider)
    {
        $this->validateProvider($request);

        $response = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            [
                'email' => $response->getEmail()
            ],
            [
                'password' => bcrypt(Str::random(16)), // Secure random password
                'email_verified_at' => now(),
                'name' => $response->getName(),
            ]
        );

        $data = [$provider . '_id' => $response->getId()];

        if ($user->wasRecentlyCreated) {
            $data['name'] = $response->getName() ?? $response->getNickname();

            event(new Registered($user));
        }

        $user->update($data);

        // Generate a token for API authentication
        $accessToken = $user->createToken('snctumToken', $abilities ?? [])->plainTextToken;

        return response()->json(['user' => $user, 'token' => $accessToken]);
    }
    protected function validateProvider(Request $request): array
    {
        return $this->getValidationFactory()->make(
            $request->route()->parameters(),
            ['provider' => 'in:facebook,google']
        )->validate();
    }
}
