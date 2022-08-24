<?php
declare(strict_types=1);

namespace App\Sharp\Commands;

use App\Models\Documents\Section;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

/**
 * Class ChildArticlesLink
 * @package App\Sharp\Commands
 */
class ChildArticlesLink extends InstanceCommand
{
    /**
    * @return string
    */
    public function label() : string
    {
        return 'Перейти на статьи';
    }

    /**
     * @param string $instanceId
     * @param array $data
     * @return array
     */
    public function execute($instanceId, array $data = []) : array
    {
        return $this->link('/admin/list/articles?filter_'.Section::FILTER_NAME.'='.$instanceId.'&page=1');
    }
}
