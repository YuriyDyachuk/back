<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth\Presenters;

use Psr\ApiAuth\Contracts\Presenters\AuthPermissionPresenterInterface;

class AuthTokenPresenter implements AuthPermissionPresenterInterface
{
    public function format(string $credential): array
    {
        return [
            'data' => [
                'token' => $credential,
            ],
        ];
    }
}
