<?php
declare(strict_types=1);

namespace App\Components\CategorySynchronizer;

use App\Components\CategorySynchronizer\DbGateways\CategorySyncDbGateway;
use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\EntitiesSynchronizer\EntitySyncAuditor;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class CategorySyncAuditorFactory implements EntitySyncAuditorFactoryInterface
{
    public const AUDITOR_KEY = 'categories';

    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(CategorySyncDbGateway $categorySyncDbGateway)
    {
        $this->syncAuditorDbGateway = $categorySyncDbGateway;
    }

    public function getEntityKey(): string
    {
        return self::AUDITOR_KEY;
    }

    public function makeAuditor(): SynchronizeAuditorInterface
    {
        return new EntitySyncAuditor($this->syncAuditorDbGateway);
    }
}
