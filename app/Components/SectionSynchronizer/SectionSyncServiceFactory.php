<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer;

use App\Components\EntitiesSynchronizer\EntitySyncService;
use App\Components\SectionSynchronizer\DbGateways\SectionSyncDbGateway;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class SectionSyncServiceFactory implements SynchronizableFactoryInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(SectionSyncDbGateway $sectionSyncDbGateway)
    {
        $this->syncDbGateway = $sectionSyncDbGateway;
    }

    public function makeSynchronizable(): SynchronizableInterface
    {
        return new EntitySyncService($this->syncDbGateway);
    }
}
