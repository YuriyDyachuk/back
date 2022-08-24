<?php
declare(strict_types=1);

namespace App\Services\SocialAuth\Providers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


/**
 * Class GoogleProvider
 * @package App\Services\SocialAuth\Providers
 */
class GoogleProvider
{
    private $oauth2Url = 'https://oauth2.googleapis.com/tokeninfo?';
//    private $oauth2Url = 'https://www.googleapis.com/oauth2/v1/userinfo';

    private $token;

    public function __construct($token)
    {
      $this->token = $token;
    }

    public function parseToken()
    {
        $response = Http::get($this->oauth2Url, [
            'id_token' => $this->token,
        ]);
        Log::info('token: ' . $this->token);
        Log::info('url: ' . json_encode($response));

        if (!$response->successful()) {
            $info = null;
        } else {
            $info = $response->json();
        }

        return [
            'successful' => $response->successful(),
            'response' => $info
        ];

    }
}
