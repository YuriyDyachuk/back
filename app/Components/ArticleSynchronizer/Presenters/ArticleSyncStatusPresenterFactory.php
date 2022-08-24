<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer\Presenters;

use App\Components\ArticleSynchronizer\ArticleSyncAuditorFactory;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class ArticleSyncStatusPresenterFactory implements EntitySyncStatusPresenterFactoryInterface
{
    public const STATUS_KEY = ArticleSyncAuditorFactory::AUDITOR_KEY;

    private EntitySyncStatusPresenterInterface $syncStatusPresenter;

    public function __construct(ArticleSyncStatusPresenter $syncStatusPresenter)
    {
        $this->syncStatusPresenter = $syncStatusPresenter;
    }

    public function make(): EntitySyncStatusPresenterInterface
    {
        return $this->syncStatusPresenter;
    }
}
