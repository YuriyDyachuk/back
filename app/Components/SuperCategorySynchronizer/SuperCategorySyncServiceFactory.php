<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer;

use App\Components\EntitiesSynchronizer\EntitySyncService;
use App\Components\SuperCategorySynchronizer\DbGateways\SuperCategorySyncDbGateway;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class SuperCategorySyncServiceFactory implements SynchronizableFactoryInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(SuperCategorySyncDbGateway $superCategorySyncDbGateway)
    {
        $this->syncDbGateway = $superCategorySyncDbGateway;
    }

    public function makeSynchronizable(): SynchronizableInterface
    {
        return new EntitySyncService($this->syncDbGateway);
    }
}
