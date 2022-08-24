<?php
declare(strict_types=1);

namespace App\Components\ArticleSynchronizer;

use App\Components\ArticleSynchronizer\DbGateways\ArticleSyncDbGateway;
use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\EntitiesSynchronizer\EntitySyncAuditor;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class ArticleSyncAuditorFactory implements EntitySyncAuditorFactoryInterface
{
    public const AUDITOR_KEY = 'articles';

    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(ArticleSyncDbGateway $articleSyncDbGateway)
    {
        $this->syncAuditorDbGateway = $articleSyncDbGateway;
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
