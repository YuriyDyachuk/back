<?php
declare(strict_types=1);

namespace App\Sharp\Commands;

use App\Models\Categories\Category;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

/**
 * Class ChildDocumentsLink
 * @package App\Sharp\Commands
 */
class ChildDocumentsLink extends InstanceCommand
{
    /**
    * @return string
    */
    public function label() : string
    {
        return 'Перейти на документы';
    }

    /**
     * @param string $instanceId
     * @param array $data
     * @return array
     */
    public function execute($instanceId, array $data = []) : array
    {
        return $this->link('/admin/list/documents?filter_'.Category::FILTER_NAME.'='.$instanceId.'&page=1');
    }
}
