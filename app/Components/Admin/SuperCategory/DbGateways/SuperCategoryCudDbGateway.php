<?php
declare(strict_types=1);

namespace App\Components\Admin\SuperCategory\DbGateways;

use App\Components\Admin\Entity\DbGateways\AbstractEloquentEntityCudDbGateway;
use App\Models\Categories\SuperCategory;

class SuperCategoryCudDbGateway extends AbstractEloquentEntityCudDbGateway
{
    protected function getModelClassname(): string
    {
        return SuperCategory::class;
    }
}
