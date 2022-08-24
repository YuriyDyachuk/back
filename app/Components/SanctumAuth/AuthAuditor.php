<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Psr\ApiAuth\Contracts\AuthenticableAuditorInterface;

class AuthAuditor implements AuthenticableAuditorInterface
{
    public function canAuthenticate(array $authData, array $credentials): bool
    {
        /** @var Authenticatable|null $authenticatable */
        $authenticatable = $authData['user'];

        return $authData['user'] !== null && Hash::check($credentials['password'], $authenticatable->getAuthPassword());
    }
}
