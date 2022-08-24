<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer\DbGateways;

use App\Components\EntitiesSynchronizer\DbGateways\EloquentSyncTableDetailsTrait;
use App\Components\EntitiesSynchronizer\DbGateways\QuerySyncDbGatewayTrait;
use App\Models\Documents\Article;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;

class ArticleSyncDbGateway implements SyncDbGatewayInterface, SyncAuditorDbGatewayInterface
{
    use QuerySyncDbGatewayTrait;
    use EloquentSyncTableDetailsTrait;

    protected function getModelClassname(): string
    {
        return Article::class;
    }
}
