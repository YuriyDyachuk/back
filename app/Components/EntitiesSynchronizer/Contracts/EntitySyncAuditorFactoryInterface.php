<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Contracts;

use Psr\Synchronizer\Contracts\SynchronizeAuditorFactoryInterface;

interface EntitySyncAuditorFactoryInterface extends SynchronizeAuditorFactoryInterface
{
    public function getEntityKey(): string;
}
