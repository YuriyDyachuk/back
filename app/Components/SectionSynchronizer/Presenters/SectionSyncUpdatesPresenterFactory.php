<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Presenters\EntitySyncUpdatesPresenter;
use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\Section\Presenters\SectionPresenterFactory;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class SectionSyncUpdatesPresenterFactory implements SyncUpdatesPresenterFactoryInterface
{
    private EntityPresenterFactoryInterface $entityPresenterFactory;

    public function __construct(SectionPresenterFactory $sectionPresenterFactory)
    {
        $this->entityPresenterFactory = $sectionPresenterFactory;
    }

    public function make(): SyncUpdatesPresenterInterface
    {
        return new EntitySyncUpdatesPresenter(
            $this->entityPresenterFactory->make()
        );
    }
}
