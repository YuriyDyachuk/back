<?php
declare(strict_types=1);

namespace App\Components\Document\DbGateways;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentEntityPaginatedTrait;
use App\Models\Documents\Document;

class DocumentPaginatedDbGateway implements EntityPaginatedDbGatewayInterface
{
    use EloquentEntityPaginatedTrait;

    protected function getModelClassname(): string
    {
        return Document::class;
    }
}
