<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthenticableAuditorInterface
{
    public function canAuthenticate(array $authData, array $credentials): bool;
}
