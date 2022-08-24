<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthFactoryInterface
{
    public function make(): AuthenticatorInterface;
}
