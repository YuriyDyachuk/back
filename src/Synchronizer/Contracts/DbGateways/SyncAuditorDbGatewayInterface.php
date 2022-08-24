<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\DbGateways;

interface SyncAuditorDbGatewayInterface
{
    public function isSynchronized(int $lastSyncTimestamp): bool;
}
