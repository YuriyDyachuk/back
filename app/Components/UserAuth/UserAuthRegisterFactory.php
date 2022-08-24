<?php
declare(strict_types=1);

namespace App\Components\UserAuth;

use App\Components\UserAuth\Contracts\DbGateways\UserFetcherDbGatewayInterface;
use App\Components\UserAuth\DbGateways\UserAuthDbGateway;
use Psr\ApiAuth\Contracts\AuthenticableRegisterInterface;
use Psr\ApiAuth\Contracts\AuthRegisterFactoryInterface;

class UserAuthRegisterFactory implements AuthRegisterFactoryInterface
{
    private UserFetcherDbGatewayInterface $fetcherDbGateway;

    public function __construct(UserAuthDbGateway $fetcherDbGateway)
    {
        $this->fetcherDbGateway = $fetcherDbGateway;
    }

    public function make(): AuthenticableRegisterInterface
    {
        return new UserAuthRegister(
            $this->fetcherDbGateway
        );
    }
}
