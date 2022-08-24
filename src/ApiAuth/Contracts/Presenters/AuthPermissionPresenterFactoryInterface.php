<?php
declare(strict_types=1);

namespace Psr\ApiAuth\Contracts\Presenters;

interface AuthPermissionPresenterFactoryInterface
{
    public function make(): AuthPermissionPresenterInterface;
}
