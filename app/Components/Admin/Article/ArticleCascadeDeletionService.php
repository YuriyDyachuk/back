<?php
declare(strict_types=1);

namespace App\Components\Admin\Article;

use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;

class ArticleCascadeDeletionService implements EntityCascadeDeletionInterface, EntityPluralCascadeDeletionInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    public function __construct(EntityPluralCascadeDeletionDbGatewayInterface $pluralCascadeDeletionDbGateway)
    {
        $this->cascadeDeletionDbGateway = $pluralCascadeDeletionDbGateway;
    }

    public function deleteRelatedByForeignKey(int $foreignKey): void
    {
        $articleIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKey($foreignKey);

        $this->cascadeDeletionDbGateway->deleteByIds($articleIds);
    }

    public function deleteRelatedByForeignKeys(array $foreignKeys): void
    {
        $articleIds = $this->cascadeDeletionDbGateway->selectIdsByForeignKeys($foreignKeys);

        $this->cascadeDeletionDbGateway->deleteByIds($articleIds);
    }
}
