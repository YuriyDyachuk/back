<?php
declare(strict_types=1);

namespace App\Components\SuperCategorySynchronizer;

use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\EntitiesSynchronizer\EntitySyncAuditor;
use App\Components\SuperCategorySynchronizer\DbGateways\SuperCategorySyncDbGateway;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class SuperCategorySyncAuditorFactory implements EntitySyncAuditorFactoryInterface
{
    public const AUDITOR_KEY = 'superCategories';

    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(SuperCategorySyncDbGateway $superCategorySyncDbGateway)
    {
        $this->syncAuditorDbGateway = $superCategorySyncDbGateway;
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
