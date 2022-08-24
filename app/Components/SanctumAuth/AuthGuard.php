<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth;

use App\Models\User;
use Psr\ApiAuth\Contracts\AuthGuardInterface;

class AuthGuard implements AuthGuardInterface
{
    public function grandPermission(array $authenticable): string
    {
        /** @var User $user */
        $user = $authenticable['user'];
        $deviceName = $authenticable['deviceName'];

        return $user->createToken($deviceName)
            ->plainTextToken;
    }

    public function replacePermission(array $authenticable): string
    {
        /** @var User $user */
        $user = $authenticable['user'];
        $deviceName = $authenticable['deviceName'];

        $user->tokens()
            ->where('name', $deviceName)
            ->delete();

        return $this->grandPermission($authenticable);
    }

    public function revokePermission(array $authenticated): void
    {
        /** @var User $user */
        $user = $authenticated['user'];

        $user->currentAccessToken()
            ->delete();
    }
}
