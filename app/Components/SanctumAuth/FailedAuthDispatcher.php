<?php
declare(strict_types=1);

namespace App\Components\SanctumAuth;

use Illuminate\Validation\ValidationException;
use Psr\ApiAuth\Contracts\FailedAuthDispatcherInterface;

class FailedAuthDispatcher implements FailedAuthDispatcherInterface
{
    /**
     * @throws ValidationException
     */
    public function throwFailedAuth(): void
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
}
