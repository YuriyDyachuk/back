<?php
declare(strict_types=1);

namespace App\Components\SectionSynchronizer;

use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\EntitiesSynchronizer\EntitySyncAuditor;
use App\Components\SectionSynchronizer\DbGateways\SectionSyncDbGateway;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class SectionSyncAuditorFactory implements EntitySyncAuditorFactoryInterface
{
    public const AUDITOR_KEY = 'sections';

    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(SectionSyncDbGateway $sectionSyncDbGateway)
    {
        $this->syncAuditorDbGateway = $sectionSyncDbGateway;
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
