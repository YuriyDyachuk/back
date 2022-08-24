<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts;

interface AuthGuardInterface
{
    public function grandPermission(array $authenticable): string;

    public function replacePermission(array $authenticable): string;

    public function revokePermission(array $authenticated): void;
}
