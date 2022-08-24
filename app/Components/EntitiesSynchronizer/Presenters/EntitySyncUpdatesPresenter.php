<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\Presenters;

use App\Components\Entity\Contracts\Presenters\EntityPresenterInterface;
use App\Components\Entity\Presenters\PaginatedEntityFormatterTrait;
use Psr\Synchronizer\Contracts\Presenters\SyncUpdatesPresenterInterface;

class EntitySyncUpdatesPresenter implements SyncUpdatesPresenterInterface
{
    use PaginatedEntityFormatterTrait;

    private EntityPresenterInterface $entityPresenter;

    public function __construct(EntityPresenterInterface $entityPresenter)
    {
        $this->entityPresenter = $entityPresenter;
    }

    /**
     * @param array[] $updates
     * @param array $meta
     *
     * @return array[]
     */
    public function format(array $updates, array $meta = []): array
    {
        return $this->formatPaginated($updates);
    }

    protected function getEntityPresenter(): EntityPresenterInterface
    {
        return $this->entityPresenter;
    }
}
