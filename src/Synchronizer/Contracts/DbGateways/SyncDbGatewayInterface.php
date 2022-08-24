<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\DbGateways;

interface SyncDbGatewayInterface
{
    public function getUpdatesPaginated(int $lastSyncTimestamp, array $options): array;
}
