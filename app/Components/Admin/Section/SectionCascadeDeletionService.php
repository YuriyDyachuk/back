<?php
declare(strict_types=1);

namespace App\Components\Admin\Section;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;

class SectionCascadeDeletionService implements EntityCascadeDeletionInterface, EntityPluralCascadeDeletionInterface
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
        $sectionIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKey($foreignKey);

        $this->entityCascadeDeletionService->deleteRelatedByForeignKeys($sectionIds);

        $this->cascadeDeletionDbGateway->deleteByIds($sectionIds);
    }

    public function deleteRelatedByForeignKeys(array $foreignKeys): void
    {
        $sectionIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKeys($foreignKeys);

        $this->entityCascadeDeletionService->deleteRelatedByForeignKeys($sectionIds);

        $this->cascadeDeletionDbGateway->deleteByIds($sectionIds);
    }
}
