<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthenticableRegisterInterface
{
    public function register(array $registrable): array;
}
