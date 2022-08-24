<?php
declare(strict_types=1);

namespace Psr\ApiAuth;

use Psr\ApiAuth\Contracts\AuthenticableAuditorInterface;
use Psr\ApiAuth\Contracts\AuthenticableFetcherInterface;
use Psr\ApiAuth\Contracts\AuthenticableRegisterInterface;
use Psr\ApiAuth\Contracts\AuthGuardInterface;
use Psr\ApiAuth\Contracts\FailedAuthDispatcherInterface;

class Authenticator implements Contracts\AuthenticatorInterface
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

    public function login(array $credentials): string
    {
        $authenticable = $this->authFetcher->fetch($credentials);

        if (!$this->authAuditor->canAuthenticate($authenticable, $credentials)) {
            $this->failedAuthDispatcher->throwFailedAuth();
        }

        return $this->authGuard->replacePermission(
            array_merge($credentials, $authenticable)
        );
    }

    public function register(array $registrable): string
    {
        $authenticable = $this->authRegister->register($registrable);

        return $this->authGuard->grandPermission(
            array_merge($registrable, $authenticable)
        );
    }

    public function logout(array $authenticated): void
    {
        $this->authGuard->revokePermission($authenticated);
    }
}
