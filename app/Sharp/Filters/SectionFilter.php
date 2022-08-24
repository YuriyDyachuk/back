<?php
declare(strict_types=1);

namespace App\Sharp\Filters;

use App\Models\Documents\Section;
use Code16\Sharp\EntityList\EntityListFilter;

/**
 * Class SectionFilter
 * @package App\Sharp\Filters
 */
class SectionFilter implements EntityListFilter
{
    /**
    * @return array
    */
    public function values() : array
    {
        return Section::where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('name', 'id')
            ->all();
    }
}
