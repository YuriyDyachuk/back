<?php

namespace App\Sharp;

use App\Models\User;
use Code16\Sharp\EntityList\EntityListMultipleFilter;
use Code16\Sharp\EntityList\EntityListRequiredFilter;

class UserFilter implements EntityListRequiredFilter, EntityListMultipleFilter
{
    /**
    * @return array
    */
    public function values()
    {
        return User::orderBy("name")
            ->pluck("name", "id");
    }

    /**
    * @return string|int
    */
    public function defaultValue()
    {
        //
    }
}
