<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\Presenters;

interface SyncUpdatesPresenterInterface
{
    public function format(array $updates, array $meta = []): array;
}
