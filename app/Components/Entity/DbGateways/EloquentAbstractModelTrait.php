<?php
declare(strict_types=1);

namespace App\Components\Entity\DbGateways;

trait EloquentAbstractModelTrait
{
    abstract protected function getModelClassname(): string;
}
