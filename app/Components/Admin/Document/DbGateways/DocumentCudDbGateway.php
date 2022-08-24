<?php
declare(strict_types=1);

namespace App\Components\Admin\Document\DbGateways;

use App\Components\Admin\Entity\DbGateways\AbstractEloquentEntityCudDbGateway;
use App\Models\Documents\Document;

class DocumentCudDbGateway extends AbstractEloquentEntityCudDbGateway
{
    protected function getModelClassname(): string
    {
        return Document::class;
    }
}
