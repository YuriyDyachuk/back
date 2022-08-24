<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Presenters;

use App\Components\EntitiesSynchronizer\Contracts\Presenters\EntitySyncStatusPresenterInterface;
use Psr\Synchronizer\Contracts\Presenters\SyncStatusesPresenterInterface;

class EntitiesSyncStatusPresenter implements SyncStatusesPresenterInterface
{
    /**
     * @var EntitySyncStatusPresenterInterface[]
     */
    private array $entitySyncStatusPresenters;

    /**
     * EntitiesSyncStatusPresenter constructor.
     *
     * @param EntitySyncStatusPresenterInterface[] $entitySyncStatusPresenters
     */
    public function __construct(array $entitySyncStatusPresenters)
    {
        $this->entitySyncStatusPresenters = $entitySyncStatusPresenters;
    }

    public function format(array $statuses, array $meta = []): array
    {
        $formattedStatuses = [];
        foreach ($statuses as $key => $status) {
            $formattedStatuses[$key] = $this->getStatusPresenter($key)
                ->format($status, $meta);
        }

        return $formattedStatuses;
    }

    private function getStatusPresenter(string $key): EntitySyncStatusPresenterInterface
    {
        return $this->entitySyncStatusPresenters[$key];
    }
}
