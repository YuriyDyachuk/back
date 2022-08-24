<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthenticableFetcherInterface
{
    public function fetch(array $credentials): array;
}
