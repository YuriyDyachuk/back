<?php
declare(strict_types=1);

namespace App\Components\Section\DbGateways;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentEntityPaginatedTrait;
use App\Models\Documents\Section;

class SectionPaginatedDbGateway implements EntityPaginatedDbGatewayInterface
{
    use EloquentEntityPaginatedTrait;

    protected function getModelClassname(): string
    {
        return Section::class;
    }
}
