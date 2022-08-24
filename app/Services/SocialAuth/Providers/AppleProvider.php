<?php
declare(strict_types=1);

namespace App\Services\SocialAuth\Providers;
use Illuminate\Support\Facades\Http;


/**
 * Class FacebookProvider
 * @package App\Services\SocialAuth\Providers
 */
class AppleProvider
{
    private $url = 'https://appleid.apple.com/auth/token';

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function parseToken() {

        $response = Http::get($this->url, [
            'client_id' => env('APPLE_CLIENT_ID'),
            'client_secret' => env('APPLE_CLIENT_SECRET'),
            'grant_type' => 'authorization_code'
        ]);

        if (!$response->successful()) {
            $info = null;
        } else {
            $info = $response->json();
        }

        return [
            'successful' => $response->successful(),
            'response' => $response->json()
        ];
    }
}
