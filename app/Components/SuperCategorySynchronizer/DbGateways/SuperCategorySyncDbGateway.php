<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer\DbGateways;

use App\Components\EntitiesSynchronizer\DbGateways\EloquentSyncTableDetailsTrait;
use App\Components\EntitiesSynchronizer\DbGateways\QuerySyncDbGatewayTrait;
use App\Models\Categories\SuperCategory;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;

class SuperCategorySyncDbGateway implements SyncDbGatewayInterface, SyncAuditorDbGatewayInterface
{
    use QuerySyncDbGatewayTrait;
    use EloquentSyncTableDetailsTrait;

    protected function getModelClassname(): string
    {
        return SuperCategory::class;
    }
}
