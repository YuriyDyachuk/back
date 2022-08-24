<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\Presenters;

interface SyncStatusesPresenterInterface
{
    public function format(array $statuses, array $meta = []): array;
}
