<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer\DbGateways;

use App\Components\EntitiesSynchronizer\DbGateways\EloquentSyncTableDetailsTrait;
use App\Components\EntitiesSynchronizer\DbGateways\QuerySyncDbGatewayTrait;
use App\Models\Documents\Section;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\DbGateways\SyncDbGatewayInterface;

class SectionSyncDbGateway implements SyncAuditorDbGatewayInterface, SyncDbGatewayInterface
{
    use QuerySyncDbGatewayTrait;
    use EloquentSyncTableDetailsTrait;

    protected function getModelClassname(): string
    {
        return Section::class;
    }
}
