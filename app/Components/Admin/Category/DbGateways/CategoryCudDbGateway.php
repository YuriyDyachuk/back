<?php
declare(strict_types=1);

namespace App\Components\Admin\Category\DbGateways;

use App\Components\Admin\Entity\DbGateways\AbstractEloquentEntityCudDbGateway;
use App\Models\Categories\Category;

class CategoryCudDbGateway extends AbstractEloquentEntityCudDbGateway
{
    protected function getModelClassname(): string
    {
        return Category::class;
    }
}
