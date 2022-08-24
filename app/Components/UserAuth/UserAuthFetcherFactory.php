<?php
declare(strict_types=1);

namespace App\Components\UserAuth;

use App\Components\UserAuth\Contracts\DbGateways\UserFetcherDbGatewayInterface;
use App\Components\UserAuth\DbGateways\UserAuthDbGateway;
use Psr\ApiAuth\Contracts\AuthenticableFetcherInterface;
use Psr\ApiAuth\Contracts\AuthFetcherFactoryInterface;

class UserAuthFetcherFactory implements AuthFetcherFactoryInterface
{
    private UserFetcherDbGatewayInterface $fetcherDbGateway;

    public function __construct(UserAuthDbGateway $fetcherDbGateway)
    {
        $this->fetcherDbGateway = $fetcherDbGateway;
    }

    public function make(): AuthenticableFetcherInterface
    {
        return new UserAuthFetcher(
            $this->fetcherDbGateway
        );
    }
}
