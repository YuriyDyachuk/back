<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts;

interface EntityPluralCascadeDeletionFactoryInterface
{
    public function make(): EntityPluralCascadeDeletionInterface;
}
