<?php
declare(strict_types=1);

namespace App\Services\SocialAuth\Providers;
use Illuminate\Support\Facades\Http;


/**
 * Class FacebookProvider
 * @package App\Services\SocialAuth\Providers
 */
class FacebookProvider
{
    private $url = 'https://graph.facebook.com/me';

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function parseToken() {

        $response = Http::get($this->url, [
            'access_token' => $this->token,
            'fields' => 'first_name,email,picture'
        ]);

        if (!$response->successful()) {
            $info = null;
        } else {
            $info = $response->json();
        }
        $data = $response->json();
        
        $data['given_name'] = $data['first_name'];
        $data['picture'] = $data['picture']['data']['url'];

        return [
            'successful' => $response->successful(),
            'response' => $data
        ];

    }
}
