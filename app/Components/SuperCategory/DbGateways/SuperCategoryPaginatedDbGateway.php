<?php
declare(strict_types=1);

namespace App\Components\SuperCategory\DbGateways;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentEntityPaginatedTrait;
use App\Models\Categories\SuperCategory;

class SuperCategoryPaginatedDbGateway implements EntityPaginatedDbGatewayInterface
{
    use EloquentEntityPaginatedTrait;

    protected function getModelClassname(): string
    {
        return SuperCategory::class;
    }
}
