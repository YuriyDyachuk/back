<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Presenters\EntitySyncUpdatesPresenter;
use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use App\Components\SuperCategory\Presenters\SuperCategoryPresenterFactory;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class SuperCategorySyncUpdatesPresenterFactory implements SyncUpdatesPresenterFactoryInterface
{
    private EntityPresenterFactoryInterface $entityPresenterFactory;

    public function __construct(SuperCategoryPresenterFactory $superCategoryPresenterFactory)
    {
        $this->entityPresenterFactory = $superCategoryPresenterFactory;
    }

    public function make(): SyncUpdatesPresenterInterface
    {
        return new EntitySyncUpdatesPresenter(
            $this->entityPresenterFactory->make()
        );
    }
}
