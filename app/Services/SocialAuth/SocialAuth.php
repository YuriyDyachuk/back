<?php
declare(strict_types=1);

namespace App\Services\SocialAuth;

use App\Services\SocialAuth\Providers\AppleProvider;
use App\Services\SocialAuth\Providers\FacebookProvider;
use App\Services\SocialAuth\Providers\GoogleProvider;

/**
 * Class SocialAuth
 * @package App\Services\SocialAuth
 */
class SocialAuth
{
    private $driver;

    private $provider = [
        "google" => GoogleProvider::class,
        "facebook" => FacebookProvider::class,
        "apple" => AppleProvider::class
    ];

    public function __construct(string $driver)
    {
        $this->driver = $driver;
        $this->provider = $this->provider[$this->driver];
    }

    public function getUserFromToken(string $token)
    {
        $provider = new $this->provider($token);
        $data = $provider->parseToken();

        if(!$data['successful']) {
            return null;
        }

        return $data['response'];
    }
}
