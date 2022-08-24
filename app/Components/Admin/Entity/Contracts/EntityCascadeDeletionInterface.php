<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts;

interface EntityCascadeDeletionInterface
{
    public function deleteRelatedByForeignKey(int $foreignKey): void;
}
