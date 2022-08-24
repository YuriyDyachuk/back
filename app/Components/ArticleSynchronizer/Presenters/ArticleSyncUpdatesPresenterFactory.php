<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer\Presenters;

use App\Components\Article\Presenters\ArticlePresenterFactory;
use App\Components\EntitiesSynchronizer\Presenters\EntitySyncUpdatesPresenter;
use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class ArticleSyncUpdatesPresenterFactory implements SyncUpdatesPresenterFactoryInterface
{
    private EntityPresenterFactoryInterface $entityPresenterFactory;

    public function __construct(ArticlePresenterFactory $articlePresenterFactory)
    {
        $this->entityPresenterFactory = $articlePresenterFactory;
    }

    public function make(): SyncUpdatesPresenterInterface
    {
        return new EntitySyncUpdatesPresenter(
            $this->entityPresenterFactory->make()
        );
    }
}
