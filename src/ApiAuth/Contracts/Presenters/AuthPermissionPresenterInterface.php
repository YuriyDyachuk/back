<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts\Presenters;

interface AuthPermissionPresenterInterface
{
    public function format(string $credential): array;
}
