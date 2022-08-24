<?php
declare(strict_types=1);

namespace App\Components\Admin\Category;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;

class CategoryCascadeDeletionService implements EntityCascadeDeletionInterface
{
    private EntityCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    private EntityPluralCascadeDeletionInterface $entityCascadeDeletionService;

    public function __construct(
        EntityCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway,
        EntityPluralCascadeDeletionInterface $pluralCascadeDeletionService
    ) {
        $this->cascadeDeletionDbGateway = $cascadeDeletionDbGateway;
        $this->entityCascadeDeletionService = $pluralCascadeDeletionService;
    }

    public function deleteRelatedByForeignKey(int $foreignKey): void
    {
        $categoryIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKey($foreignKey);

        $this->entityCascadeDeletionService->deleteRelatedByForeignKeys($categoryIds);

        $this->cascadeDeletionDbGateway->deleteByIds($categoryIds);
    }
}
