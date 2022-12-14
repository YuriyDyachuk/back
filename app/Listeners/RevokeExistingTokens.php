<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
class RevokeExistingTokens
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::find($event->userId);

        if ($user->id !== 113) {
            $user->tokens()->limit(PHP_INT_MAX)->offset(1)->get()->map(function ($token) {
                $token->revoke();
            });
        }

    }
}
