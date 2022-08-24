<?php
declare(strict_types=1);

namespace App\Components\UserAuth\Contracts\DbGateways;

interface UserRegisterDbGatewayInterface
{
    public function store(array $user): array;
}
