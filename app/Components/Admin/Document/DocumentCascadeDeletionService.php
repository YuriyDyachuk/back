<?php
declare(strict_types=1);

namespace App\Components\Admin\Document;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;

class DocumentCascadeDeletionService implements EntityCascadeDeletionInterface, EntityPluralCascadeDeletionInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    private EntityPluralCascadeDeletionInterface $entityCascadeDeletionService;

    public function __construct(
        EntityPluralCascadeDeletionDbGatewayInterface $pluralCascadeDeletionDbGateway,
        EntityPluralCascadeDeletionInterface $pluralCascadeDeletionService
    ) {
        $this->cascadeDeletionDbGateway = $pluralCascadeDeletionDbGateway;
        $this->entityCascadeDeletionService = $pluralCascadeDeletionService;
    }

    public function deleteRelatedByForeignKey(int $foreignKey): void
    {
        $documentIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKey($foreignKey);

        $this->entityCascadeDeletionService->deleteRelatedByForeignKeys($documentIds);

        $this->cascadeDeletionDbGateway->deleteByIds($documentIds);
    }

    public function deleteRelatedByForeignKeys(array $foreignKeys): void
    {
        $documentIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKeys($foreignKeys);

        $this->entityCascadeDeletionService->deleteRelatedByForeignKeys($documentIds);

        $this->cascadeDeletionDbGateway->deleteByIds($documentIds);
    }
}
