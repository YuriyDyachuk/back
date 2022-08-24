<?php
declare(strict_types=1);

namespace Psr\Synchronizer\Contracts\Presenters;

interface SyncUpdatesPresenterFactoryInterface
{
    public function make(): SyncUpdatesPresenterInterface;
}
