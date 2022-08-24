<?php
declare(strict_types=1);

namespace App\Sharp\Filters;

use App\Models\Documents\Document;
use Code16\Sharp\EntityList\EntityListFilter;

/**
 * Class DocumentFilter
 * @package App\Sharp\Filters
 */
class DocumentFilter implements EntityListFilter
{
    /**
    * @return array
    */
    public function values() : array
    {
        return Document::where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('name', 'id')
            ->all();
    }
}
