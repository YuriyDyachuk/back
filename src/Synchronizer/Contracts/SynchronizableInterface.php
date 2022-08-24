<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizableInterface
{
    public function synchronize(int $lastSyncTimestamp, array $options = []): array;
}
