<?php
declare(strict_types=1);

namespace App\Components\UserAuth\DbGateways;

use App\Components\UserAuth\Contracts\DbGateways\UserFetcherDbGatewayInterface;
use App\Components\UserAuth\Contracts\DbGateways\UserRegisterDbGatewayInterface;
use App\Models\User;

class UserAuthDbGateway implements UserRegisterDbGatewayInterface, UserFetcherDbGatewayInterface
{
    public function store(array $user): array
    {
        return [
            'user' => User::create($user),
        ];
    }

    public function getByEmail(string $email): array
    {
        return [
            'user' => User::where('email', $email)
                ->first(),
        ];
    }
}
