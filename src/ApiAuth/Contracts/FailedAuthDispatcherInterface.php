<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface FailedAuthDispatcherInterface
{
    public function throwFailedAuth(): void;
}
