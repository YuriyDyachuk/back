<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;
use App\Components\SuperCategorySynchronizer\SuperCategorySyncAuditorFactory;

class SuperCategorySyncStatusPresenterFactory implements EntitySyncStatusPresenterFactoryInterface
{
    public const STATUS_KEY = SuperCategorySyncAuditorFactory::AUDITOR_KEY;

    private EntitySyncStatusPresenterInterface $syncStatusPresenter;

    public function __construct(SuperCategorySyncStatusPresenter $syncStatusPresenter)
    {
        $this->syncStatusPresenter = $syncStatusPresenter;
    }

    public function make(): EntitySyncStatusPresenterInterface
    {
        return $this->syncStatusPresenter;
    }
}
