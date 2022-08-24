<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts\DbGateways;

interface EntityPluralDeletionDbGatewayInterface
{
    /**
     * @param int[] $ids
     */
    public function deleteByIds(array $ids): void;
}
