<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer;

use App\Components\ArticleSynchronizer\ArticleSyncAuditorFactory;
use App\Components\CategorySynchronizer\CategorySyncAuditorFactory;
use App\Components\DocumentSynchronizer\DocumentSyncAuditorFactory;
use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\SectionSynchronizer\SectionSyncAuditorFactory;
use App\Components\SuperCategorySynchronizer\SuperCategorySyncAuditorFactory;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;
use Psr\Synchronizer\Contracts\SynchronizerFactoryInterface;
use Psr\Synchronizer\Contracts\SynchronizerInterface;
use Psr\Synchronizer\SynchronizerFactory;

class EntitiesSynchronizerFactory implements SynchronizerFactoryInterface
{
    private const AUDITOR_FACTORIES = [
        SuperCategorySyncAuditorFactory::class,
        CategorySyncAuditorFactory::class,
        DocumentSyncAuditorFactory::class,
        SectionSyncAuditorFactory::class,
        ArticleSyncAuditorFactory::class,
    ];

    private SynchronizerFactoryInterface $synchronizerFactory;

    public function __construct()
    {
        $this->synchronizerFactory = new SynchronizerFactory(
            $this->resolveAuditors()
        );
    }

    public function makeSynchronizer(): SynchronizerInterface
    {
        return $this->synchronizerFactory->makeSynchronizer();
    }

    /**
     * @return SynchronizeAuditorInterface[]
     */
    private function resolveAuditors(): array
    {
        $auditors = [];
        foreach (self::AUDITOR_FACTORIES as $factoryClassname) {
            /** @var EntitySyncAuditorFactoryInterface $factory */
            $factory = app($factoryClassname);

            $auditors[$factory->getEntityKey()] = $factory->makeAuditor();
        }

        return $auditors;
    }
}
