<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizeAuditorInterface
{
    public function isSynchronized(int $lastSyncTimestamp): bool;
}
