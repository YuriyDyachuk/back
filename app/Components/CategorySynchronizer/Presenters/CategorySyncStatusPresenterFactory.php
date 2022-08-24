<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer\Presenters;

use App\Components\CategorySynchronizer\CategorySyncAuditorFactory;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class CategorySyncStatusPresenterFactory implements EntitySyncStatusPresenterFactoryInterface
{
    public const STATUS_KEY = CategorySyncAuditorFactory::AUDITOR_KEY;

    private EntitySyncStatusPresenterInterface $syncStatusPresenter;

    public function __construct(CategorySyncStatusPresenter $syncStatusPresenter)
    {
        $this->syncStatusPresenter = $syncStatusPresenter;
    }

    public function make(): EntitySyncStatusPresenterInterface
    {
        return $this->syncStatusPresenter;
    }
}
