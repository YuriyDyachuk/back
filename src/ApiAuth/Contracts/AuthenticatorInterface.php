<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthenticatorInterface
{
    public function login(array $credentials): string;

    public function register(array $registrable): string;

    public function logout(array $authenticated): void;
}
