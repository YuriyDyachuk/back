<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer\Presenters;

use App\Components\Category\Presenters\CategoryPresenterFactory;
use App\Components\EntitiesSynchronizer\Presenters\EntitySyncUpdatesPresenter;
use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class CategorySyncUpdatesPresenterFactory implements SyncUpdatesPresenterFactoryInterface
{
    private EntityPresenterFactoryInterface $entityPresenterFactory;

    public function __construct(CategoryPresenterFactory $categoryPresenterFactory)
    {
        $this->entityPresenterFactory = $categoryPresenterFactory;
    }

    public function make(): SyncUpdatesPresenterInterface
    {
        return new EntitySyncUpdatesPresenter(
            $this->entityPresenterFactory->make()
        );
    }
}
