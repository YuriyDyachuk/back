<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth\Presenters;

use Psr\ApiAuth\Contracts\Presenters\AuthPermissionPresenterFactoryInterface;
use Psr\ApiAuth\Contracts\Presenters\AuthPermissionPresenterInterface;

class AuthTokenPresenterFactory implements AuthPermissionPresenterFactoryInterface
{
    private AuthPermissionPresenterInterface $authPresenter;

    public function __construct(AuthTokenPresenter $authPresenter)
    {
        $this->authPresenter = $authPresenter;
    }

    public function make(): AuthPermissionPresenterInterface
    {
        return $this->authPresenter;
    }
}
