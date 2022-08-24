<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthFetcherFactoryInterface
{
    public function make(): AuthenticableFetcherInterface;
}
