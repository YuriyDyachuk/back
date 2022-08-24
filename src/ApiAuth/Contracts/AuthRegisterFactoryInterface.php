<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthRegisterFactoryInterface
{
    public function make(): AuthenticableRegisterInterface;
}
