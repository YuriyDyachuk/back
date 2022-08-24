<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts;

interface SynchronizerInterface
{
    public function getStatues(int $lastSyncTimestamp): array;
}
