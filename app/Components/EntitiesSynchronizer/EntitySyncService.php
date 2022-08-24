<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer;

use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizableInterface;

class EntitySyncService implements SynchronizableInterface
{
    private SyncDbGatewayInterface $syncDbGateway;

    public function __construct(SyncDbGatewayInterface $syncDbGateway)
    {
        $this->syncDbGateway = $syncDbGateway;
    }

    public function synchronize(int $lastSyncTimestamp, array $options = []): array
    {
        return $this->syncDbGateway->getUpdatesPaginated($lastSyncTimestamp, $options);
    }
}
