<?php
declare(strict_types=1);

namespace App\Components\Category\DbGateways;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentEntityPaginatedTrait;
use App\Models\Categories\Category;

class CategoryPaginatedDbGateway implements EntityPaginatedDbGatewayInterface
{
    use EloquentEntityPaginatedTrait;

    protected function getModelClassname(): string
    {
        return Category::class;
    }
}
