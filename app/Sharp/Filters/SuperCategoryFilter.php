<?php
declare(strict_types=1);

namespace App\Sharp\Filters;

use App\Models\Categories\SuperCategory;
use Code16\Sharp\EntityList\EntityListFilter;

class SuperCategoryFilter implements EntityListFilter
{
    /**
    * @return array
    */
    public function values() : array
    {
        return SuperCategory::where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('name', 'id')
            ->all();
    }
}
