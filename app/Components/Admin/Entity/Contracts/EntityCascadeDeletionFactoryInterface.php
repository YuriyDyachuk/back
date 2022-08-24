<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts;

interface EntityCascadeDeletionFactoryInterface
{
    public function make(): EntityCascadeDeletionInterface;
}
