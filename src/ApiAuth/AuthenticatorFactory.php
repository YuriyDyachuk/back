<?php
declare(strict_types=1);

namespace Psr\ApiAuth;

use Psr\ApiAuth\Contracts\AuthenticableAuditorInterface;
use Psr\ApiAuth\Contracts\AuthenticableFetcherInterface;
use Psr\ApiAuth\Contracts\AuthenticableRegisterInterface;
use Psr\ApiAuth\Contracts\AuthenticatorInterface;
use Psr\ApiAuth\Contracts\AuthGuardInterface;
use Psr\ApiAuth\Contracts\FailedAuthDispatcherInterface;

class AuthenticatorFactory implements Contracts\AuthFactoryInterface
{
    private AuthenticableFetcherInterface $authFetcher;

    private AuthenticableAuditorInterface $authAuditor;

    private FailedAuthDispatcherInterface $failedAuthDispatcher;

    private AuthGuardInterface $authGuard;

    private AuthenticableRegisterInterface $authRegister;

    public function __construct(
        AuthenticableFetcherInterface $authFetcher,
        AuthenticableAuditorInterface $authAuditor,
        FailedAuthDispatcherInterface $failedAuthDispatcher,
        AuthGuardInterface $authGuard,
        AuthenticableRegisterInterface $authRegister
    ) {
        $this->authFetcher = $authFetcher;
        $this->authAuditor = $authAuditor;
        $this->failedAuthDispatcher = $failedAuthDispatcher;
        $this->authGuard = $authGuard;
        $this->authRegister = $authRegister;
    }

    public function make(): AuthenticatorInterface
    {
        return new Authenticator(
            $this->authFetcher,
            $this->authAuditor,
            $this->failedAuthDispatcher,
            $this->authGuard,
            $this->authRegister,
        );
    }
}
