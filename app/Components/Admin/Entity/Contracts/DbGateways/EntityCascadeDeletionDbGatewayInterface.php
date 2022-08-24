<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts\DbGateways;

interface EntityCascadeDeletionDbGatewayInterface extends EntityPluralDeletionDbGatewayInterface
{
    /**
     * @param int $foreignKey
     *
     * @return int[]
     */
    public function selectIdsByForeignKey(int $foreignKey): array;
}
