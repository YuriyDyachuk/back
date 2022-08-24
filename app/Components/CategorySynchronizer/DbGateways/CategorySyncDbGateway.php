<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer\DbGateways;

use App\Components\EntitiesSynchronizer\DbGateways\EloquentSyncTableDetailsTrait;
use App\Components\EntitiesSynchronizer\DbGateways\QuerySyncDbGatewayTrait;
use App\Models\Categories\Category;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;

class CategorySyncDbGateway implements SyncDbGatewayInterface, SyncAuditorDbGatewayInterface
{
    use QuerySyncDbGatewayTrait;
    use EloquentSyncTableDetailsTrait;

    protected function getModelClassname(): string
    {
        return Category::class;
    }
}
