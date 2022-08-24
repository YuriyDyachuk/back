<?php
declare(strict_types=1);

namespace App\Sharp\Commands;

use App\Models\Documents\Document;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

/**
 * Class InsideDocumentsLink
 * @package App\Sharp\Commands
 */
class InsideDocumentsLink extends InstanceCommand
{
    /**
     * @return string
     */
    public function label() : string
    {
        return 'Редактировать';
    }

    /**
     * @param string $instanceId
     * @param array $data
     * @return array
     */
    public function execute($instanceId, array $data = []): array
    {
        return $this->link('/admin/form/documents/'.$instanceId);
    }
}
