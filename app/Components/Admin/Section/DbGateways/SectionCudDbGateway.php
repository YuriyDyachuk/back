<?php
declare(strict_types=1);

namespace App\Components\Admin\Section\DbGateways;

use App\Components\Admin\Entity\DbGateways\AbstractEloquentEntityCudDbGateway;
use App\Models\Documents\Section;

class SectionCudDbGateway extends AbstractEloquentEntityCudDbGateway
{
    protected function getModelClassname(): string
    {
        return Section::class;
    }
}
