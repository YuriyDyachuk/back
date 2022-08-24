<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer;

use App\Components\ArticleSynchronizer\DbGateways\ArticleSyncDbGateway;
use App\Components\EntitiesSynchronizer\EntitySyncService;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class ArticleSyncServiceFactory implements SynchronizableFactoryInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(ArticleSyncDbGateway $articleSyncDbGateway)
    {
        $this->syncDbGateway = $articleSyncDbGateway;
    }

    public function makeSynchronizable(): SynchronizableInterface
    {
        return new EntitySyncService($this->syncDbGateway);
    }
}
