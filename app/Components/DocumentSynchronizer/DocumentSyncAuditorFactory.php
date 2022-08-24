<?php
declare(strict_types=1);

namespace App\Components\DocumentSynchronizer;

use App\Components\DocumentSynchronizer\DbGateways\DocumentSyncDbGateway;
use App\Components\EntitiesSynchronizer\Contracts\EntitySyncAuditorFactoryInterface;
use App\Components\EntitiesSynchronizer\EntitySyncAuditor;
use Psr\Synchronizer\Contracts\DbGateways\SyncAuditorDbGatewayInterface;
use Psr\Synchronizer\Contracts\SynchronizeAuditorInterface;

class DocumentSyncAuditorFactory implements EntitySyncAuditorFactoryInterface
{
    public const AUDITOR_KEY = 'documents';

    private SyncAuditorDbGatewayInterface $syncAuditorDbGateway;

    public function __construct(DocumentSyncDbGateway $documentSyncDbGateway)
    {
        $this->syncAuditorDbGateway = $documentSyncDbGateway;
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
