<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\Presenters;

interface SyncStatusesPresenterFactoryInterface
{
    public function make(): SyncStatusesPresenterInterface;
}
