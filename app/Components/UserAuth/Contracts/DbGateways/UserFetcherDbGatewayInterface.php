<?php
declare(strict_types=1);

namespace App\Components\UserAuth\Contracts\DbGateways;

interface UserFetcherDbGatewayInterface
{
    public function getByEmail(string $email): array;
}
