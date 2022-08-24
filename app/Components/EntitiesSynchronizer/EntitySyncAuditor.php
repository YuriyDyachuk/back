<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer;

use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class EntitySyncAuditor implements SynchronizeAuditorInterface
{
    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(SyncAuditorDbGatewayInterface $syncAuditorDbGateway)
    {
        $this->syncAuditorDbGateway = $syncAuditorDbGateway;
    }

    public function isSynchronized(int $lastSyncTimestamp): bool
    {
        return $this->syncAuditorDbGateway->isSynchronized($lastSyncTimestamp);
    }
}
