<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts;

interface EntityPluralCascadeDeletionInterface
{
    /**
     * @param int[] $foreignKeys
     */
    public function deleteRelatedByForeignKeys(array $foreignKeys): void;
}
