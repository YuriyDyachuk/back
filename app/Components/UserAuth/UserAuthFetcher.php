<?php
declare(strict_types=1);

namespace App\Components\UserAuth;

use App\Components\UserAuth\Contracts\DbGateways\UserFetcherDbGatewayInterface;
use Psr\ApiAuth\Contracts\AuthenticableFetcherInterface;

class UserAuthFetcher implements AuthenticableFetcherInterface
{
    private UserFetcherDbGatewayInterface $fetcherDbGateway;

    public function __construct(UserFetcherDbGatewayInterface $fetcherDbGateway)
    {
        $this->fetcherDbGateway = $fetcherDbGateway;
    }

    public function fetch(array $credentials): array
    {
        return $this->fetcherDbGateway->getByEmail(
            $credentials['email']
        );
    }
}
