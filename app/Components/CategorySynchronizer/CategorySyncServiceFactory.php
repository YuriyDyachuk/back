<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer;

use App\Components\CategorySynchronizer\DbGateways\CategorySyncDbGateway;
use App\Components\EntitiesSynchronizer\EntitySyncService;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class CategorySyncServiceFactory implements SynchronizableFactoryInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(CategorySyncDbGateway $categorySyncDbGateway)
    {
        $this->syncDbGateway = $categorySyncDbGateway;
        $this->id = [3,null];
    }

    public function makeSynchronizable(): SynchronizableInterface
    {
        return new EntitySyncService($this->syncDbGateway, $this->id);
    }
}
