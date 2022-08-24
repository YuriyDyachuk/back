<?php
declare(strict_types=1);

namespace App\Components\EntitiesSynchronizer\DbGateways;

use App\Components\Entity\DbGateways\EloquentGetPureModelInstanceTrait;

trait EloquentSyncTableDetailsTrait
{
    use EloquentGetPureModelInstanceTrait;

    protected function getTable(): string
    {
        return $this->getModelInstance()
            ->getTable();
    }

    protected function getCreatedAtColumn(): string
    {
        return $this->getModelInstance()
            ->getCreatedAtColumn();
    }

    protected function getUpdatedAtColumn(): string
    {
        return $this->getModelInstance()
            ->getUpdatedAtColumn();
    }

    protected function getDeletedAtColumn(): string
    {
        return $this->getModelInstance()
            ->getDeletedAtColumn();
    }
}
