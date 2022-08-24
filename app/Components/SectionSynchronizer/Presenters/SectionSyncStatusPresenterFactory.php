<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;
use App\Components\SectionSynchronizer\SectionSyncAuditorFactory;

class SectionSyncStatusPresenterFactory implements EntitySyncStatusPresenterFactoryInterface
{
    public const STATUS_KEY = SectionSyncAuditorFactory::AUDITOR_KEY;

    private EntitySyncStatusPresenterInterface $syncStatusPresenter;

    public function __construct(SectionSyncStatusPresenter $syncStatusPresenter)
    {
        $this->syncStatusPresenter = $syncStatusPresenter;
    }

    public function make(): EntitySyncStatusPresenterInterface
    {
        return $this->syncStatusPresenter;
    }
}
