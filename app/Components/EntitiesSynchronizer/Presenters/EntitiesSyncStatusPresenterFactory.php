<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Presenters;

use App\Components\ArticleSynchronizer\Presenters\ArticleSyncStatusPresenterFactory;
use App\Components\CategorySynchronizer\Presenters\CategorySyncStatusPresenterFactory;
use App\Components\DocumentSynchronizer\Presenters\DocumentSyncStatusPresenterFactory;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterFactoryInterface;
use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;
use App\Components\SectionSynchronizer\Presenters\SectionSyncStatusPresenterFactory;
use App\Components\SuperCategorySynchronizer\Presenters\SuperCategorySyncStatusPresenterFactory;
use Psr\Synchronizer\Contracts\Presenters\SyncStatusesPresenterFactoryInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncStatusesPresenterInterface;

class EntitiesSyncStatusPresenterFactory implements SyncStatusesPresenterFactoryInterface
{
    private const ENTITY_PRESENTER_FACTORIES = [
        SuperCategorySyncStatusPresenterFactory::STATUS_KEY => SuperCategorySyncStatusPresenterFactory::class,
        CategorySyncStatusPresenterFactory::STATUS_KEY => CategorySyncStatusPresenterFactory::class,
        DocumentSyncStatusPresenterFactory::STATUS_KEY => DocumentSyncStatusPresenterFactory::class,
        SectionSyncStatusPresenterFactory::STATUS_KEY => SectionSyncStatusPresenterFactory::class,
        ArticleSyncStatusPresenterFactory::STATUS_KEY => ArticleSyncStatusPresenterFactory::class,
    ];

    public function make(): SyncStatusesPresenterInterface
    {
        return new EntitiesSyncStatusPresenter(
            $this->resolveEntityPresenters()
        );
    }

    /**
     * @return EntitySyncStatusPresenterInterface[]
     */
    private function resolveEntityPresenters(): array
    {
        $presenters = [];
        foreach (self::ENTITY_PRESENTER_FACTORIES as $key => $factoryClassname) {
            /** @var EntitySyncStatusPresenterFactoryInterface $factory */
            $factory = app($factoryClassname);

            $presenters[$key] = $factory->make();
        }

        return $presenters;
    }
}
