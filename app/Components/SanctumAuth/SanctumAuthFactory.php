<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth;

use App\Components\UserAuth\UserAuthFetcherFactory;
use App\Components\UserAuth\UserAuthRegisterFactory;
use Psr\ApiAuth\AuthenticatorFactory;
use Psr\ApiAuth\Contracts\AuthenticableAuditorInterface;
use Psr\ApiAuth\Contracts\AuthenticatorInterface;
use Psr\ApiAuth\Contracts\AuthFactoryInterface;
use Psr\ApiAuth\Contracts\AuthFetcherFactoryInterface;
use Psr\ApiAuth\Contracts\AuthGuardInterface;
use Psr\ApiAuth\Contracts\AuthRegisterFactoryInterface;
use Psr\ApiAuth\Contracts\FailedAuthDispatcherInterface;

class SanctumAuthFactory implements AuthFactoryInterface
{
    private AuthFactoryInterface $authFactory;

    /**
     * SanctumAuthFactory constructor.
     *
     * @param UserAuthFetcherFactory|AuthFetcherFactoryInterface $fetcherFactory
     * @param AuthAuditor|AuthenticableAuditorInterface $authAuditor
     * @param FailedAuthDispatcher|FailedAuthDispatcherInterface $failedAuthDispatcher
     * @param AuthGuard|AuthGuardInterface $authGuard
     * @param UserAuthRegisterFactory|AuthRegisterFactoryInterface $registerFactory
     */
    public function __construct(
        UserAuthFetcherFactory $fetcherFactory,
        AuthAuditor $authAuditor,
        FailedAuthDispatcher $failedAuthDispatcher,
        AuthGuard $authGuard,
        UserAuthRegisterFactory $registerFactory
    ) {
        $this->authFactory = new AuthenticatorFactory(
            $fetcherFactory->make(),
            $authAuditor,
            $failedAuthDispatcher,
            $authGuard,
            $registerFactory->make()
        );
    }

    public function make(): AuthenticatorInterface
    {
        return $this->authFactory->make();
    }
}
