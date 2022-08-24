<?php
declare(strict_types=1);

namespace App\Components\DocumentSynchronizer\Presenters;

use App\Components\Document\Presenters\DocumentPresenterFactory;
use App\Components\EntitiesSynchronizer\Presenters\EntitySyncUpdatesPresenter;
use App\Components\Entity\Contracts\Presenters\EntityPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class DocumentSyncUpdatesPresenterFactory implements SyncUpdatesPresenterFactoryInterface
{
    private EntityPresenterFactoryInterface $entityPresenterFactory;

    public function __construct(DocumentPresenterFactory $documentPresenterFactory)
    {
        $this->entityPresenterFactory = $documentPresenterFactory;
    }

    public function make(): SyncUpdatesPresenterInterface
    {
        return new EntitySyncUpdatesPresenter(
            $this->entityPresenterFactory->make()
        );
    }
}
