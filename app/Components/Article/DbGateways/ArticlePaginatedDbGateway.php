<?php
declare(strict_types=1);

namespace App\Components\Article\DbGateways;

use App\Components\Entity\Contracts\DbGateways\EntityPaginatedDbGatewayInterface;
use App\Components\Entity\DbGateways\EloquentEntityPaginatedTrait;
use App\Models\Documents\Article;

class ArticlePaginatedDbGateway implements EntityPaginatedDbGatewayInterface
{
    use EloquentEntityPaginatedTrait;

    protected function getModelClassname(): string
    {
        return Article::class;
    }
}
