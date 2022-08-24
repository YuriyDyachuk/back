<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Contracts\Presenters;

interface EntitySyncStatusPresenterFactoryInterface
{
    public function make(): EntitySyncStatusPresenterInterface;
}
