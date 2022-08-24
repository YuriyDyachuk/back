<?php
declare(strict_types=1);

namespace App\Sharp\Commands;

use App\Models\Categories\SuperCategory;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

/**
 * Class ChildLink
 * @package App\Sharp\Commands
 */
class ChildCategoriesLink extends InstanceCommand
{
    /**
    * @return string
    */
    public function label() : string
    {
        return 'Перейти на категории';
    }

    /**
     * @param string $instanceId
     * @param array $data
     * @return array
     */
    public function execute($instanceId, array $data = []) : array
    {
        return $this->link('/admin/list/categories?filter_'.SuperCategory::FILTER_NAME.'='.$instanceId.'&page=1');
    }
}
