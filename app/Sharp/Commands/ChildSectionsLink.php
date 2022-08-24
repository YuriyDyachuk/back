<?php
declare(strict_types=1);

namespace App\Sharp\Commands;

use App\Models\Documents\Document;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

/**
 * Class ChildSectionsLink
 * @package App\Sharp\Commands
 */
class ChildSectionsLink extends InstanceCommand
{
    /**
    * @return string
    */
    public function label() : string
    {
        return 'Перейти на секции';
    }

    /**
     * @param string $instanceId
     * @param array $data
     * @return array
     */
    public function execute($instanceId, array $data = []): array
    {
        return $this->link('/admin/list/sections?filter_'.Document::FILTER_NAME.'='.$instanceId.'&page=1');
    }
}
