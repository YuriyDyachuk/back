<?php
declare(strict_types=1);

namespace App\Sharp\Filters;

use App\Models\Categories\Category;
use Code16\Sharp\EntityList\EntityListFilter;

/**
 * Class CategoryFilterName
 * @package App\Sharp\Filters
 */
class CategoryFilter implements EntityListFilter
{
    /**
    * @return array
    */
    public function values() : array
    {
        return Category::where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('name', 'id')
            ->all();
    }
}
