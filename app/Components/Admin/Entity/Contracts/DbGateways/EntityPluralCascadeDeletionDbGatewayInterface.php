<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts\DbGateways;

interface EntityPluralCascadeDeletionDbGatewayInterface extends EntityCascadeDeletionDbGatewayInterface
{
    /**
     * @param int[] $foreignKeys
     *
     * @return int[]
     */
    public function selectIdsByForeignKeys(array $foreignKeys): array;
}
