<?php
namespace App\Sharp\Auth;
use Code16\Sharp\Auth\SharpAuthenticationCheckHandler;

class MySharpCheckHandler implements SharpAuthenticationCheckHandler
{
    /**
     * @param $user
     * @return bool
     */
    public function check($user): bool
    {
        return $user->hasGroup(7);
    }
}

