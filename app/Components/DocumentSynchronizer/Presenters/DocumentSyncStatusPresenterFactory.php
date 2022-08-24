<?php
declare(strict_types=1);

namespace App\Components\DocumentSynchronizer\Presenters;

use App\Components\DocumentSynchronizer\DocumentSyncAuditorFactory;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;

class DocumentSyncStatusPresenterFactory implements EntitySyncStatusPresenterFactoryInterface
{
    public const STATUS_KEY = DocumentSyncAuditorFactory::AUDITOR_KEY;

    private EntitySyncStatusPresenterInterface $syncStatusPresenter;

    public function __construct(DocumentSyncStatusPresenter $syncStatusPresenter)
    {
        $this->syncStatusPresenter = $syncStatusPresenter;
    }

    public function make(): EntitySyncStatusPresenterInterface
    {
        return $this->syncStatusPresenter;
    }
}
