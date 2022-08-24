<?php
declare(strict_types=1);

namespace App\Components\DocumentSynchronizer;

use App\Components\DocumentSynchronizer\DbGateways\DocumentSyncDbGateway;
use App\Components\EntitiesSynchronizer\EntitySyncService;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class DocumentSyncServiceFactory implements SynchronizableFactoryInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(DocumentSyncDbGateway $documentSyncDbGateway)
    {
        $this->syncDbGateway = $documentSyncDbGateway;
    }

    public function makeSynchronizable(): SynchronizableInterface
    {
        return new EntitySyncService($this->syncDbGateway);
    }
}
